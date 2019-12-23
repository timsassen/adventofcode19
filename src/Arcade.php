<?php

namespace AOC;
use Symfony\Component\Cache\Adapter\RedisAdapter;

/**
 * Class Arcade
 * @package AOC
 */
class Arcade
{
    protected $code;
    /**
     * @var string
     */
    private $score;
    /**
     * @var array
     */
    private $screen;
    /**
     * @var int
     */
    private $frame;
    /**
     * @var array
     */
    private $returnedValues;
    /**
     * @var bool
     */
    private $gameRunning;
    /**
     * @var InteractiveOptCode
     */
    private $opCode;
    /**
     * @var int
     */
    private $break;

    private $connection;

    /**
     * Arcade constructor.
     * @param $code
     */
    public function __construct($code, $readInput)
    {

        $this->opCode = new \AOC\InteractiveOptCode($code, [], false, $readInput);
        $this->connection = RedisAdapter::createConnection("redis://localhost:6379");
        $this->screen = [];
        $this->score = '-';
        $this->frame = 0;
        $this->returnedValues = [];
        $this->gameRunning = true;
        $this->break = 0;
        $this->code = $code;
    }


    public function start()
    {
        while ($this->gameRunning) {
            foreach ($this->opCode->runInteractive() as $key => $output) {
                $returnedValues[] = $output;
                if (count($returnedValues) == 3513) {
                    $this->createPixels($returnedValues, $screen, $score);
                    $this->paint($screen, $score);
                    $this->connection->set('meta', json_encode($this->getMeta($screen, $score, ++$this->frame, $this->opCode->getLastInstruction())));
                    $this->connection->set('screen', json_encode($screen));
                    $returnedValues = [];
                }
            }
            $this->gameRunning = ($this->opCode->getLastInstruction() != 99);

            if ($this->break++ == 1000) {
                $this->gameRunning = false;
            }
        }
    }


    public function pixelLocation($screen, $pixelType)
    {
        $array_filter = array_filter($screen, function ($pixel) use ($pixelType) {
            return $pixel[2] == $pixelType;
        });
        return array_shift($array_filter);
    }


    /**
     * @param $returnedValues
     * @param $screen
     * @param $score
     */
    function createPixels($returnedValues, &$screen, &$score)
    {
        $pixels = array_chunk($returnedValues, 3);
        foreach ($pixels as $pixel) {
            if ($pixel[0] == -1 && $pixel[1] == 0) {
                $score = $pixel[2];
            }
            /**
             *
             * 0 is an empty tile. No game object appears in this tile.
             * 1 is a wall tile. Walls are indestructible barriers.
             * 2 is a block tile. Blocks can be broken by the ball.
             * 3 is a horizontal paddle tile. The paddle is indestructible.
             * 4 is a ball tile. The ball moves diagonally and bounces off objects.
             */
            switch ($pixel[2]) {
                case 0:
                    $type = ' ';
                    break;
                case 1:
                    $type = '#';
                    break;
                case 2:
                    $type = '◊';
                    break;
                case 3:
                    $type = '≡';
                    break;
                case 4:
                    $type = '⊗';
                    break;
            }
            $screen[sprintf("%s-%s", $pixel[0], $pixel[1])] = [$pixel[0], $pixel[1], $type];
        }
    }


    /**
     * @param $screen
     * @param $axis
     * @return null
     */
    function findLowest($screen, $axis)
    {
        $lowest = null;
        foreach ($screen as $pixel) {
            $lowest = ($lowest == null || $pixel[$axis] < $lowest) ? $pixel[$axis] : $lowest;
        }
        return $lowest;
    }

    /**
     * @param $screen
     * @param $axis
     * @return null
     */
    function findHighest($screen, $axis)
    {
        $highest = null;
        foreach ($screen as $pixel) {
            $highest = ($highest == null || $pixel[$axis] > $highest) ? $pixel[$axis] : $highest;
        }
        return $highest;
    }

    /**
     * @param array $screen
     * @param array $coords
     * @return mixed|null
     */
    function getCoord(array $screen = [], array $coords = [])
    {
        return (isset($screen[sprintf("%s-%s", $coords[0], $coords[1])]))
            ? $screen[sprintf("%s-%s", $coords[0], $coords[1])]
            : null;
    }

    public function getMeta($screen, $score, $frame, $lastInstruction)
    {
        $padding = 3;
        return [
            'yStart' => $this->findLowest($screen, 1) - $padding,
            'yEnd' => $this->findHighest($screen, 1) + $padding,
            'xStart' => $this->findLowest($screen, 0) - $padding,
            'xEnd' => $this->findHighest($screen, 0) + $padding,
            'lastInstruction' => $lastInstruction,
            'frame' => $frame,
            'score' => $score,
        ];
    }

    /**
     * @param $screen
     * @param $score
     */
    function paint($screen, $score)
    {
        $padding = 3;

        $leftY = $this->findLowest($screen, 1) - $padding;
        $topleft = $this->findLowest($screen, 0) - $padding;
        for ($i = $leftY; $i <= $this->findHighest($screen, 1) + $padding; $i++) {
            for ($j = $topleft; $j <= $this->findHighest($screen, 0) + $padding; $j++) {
                $coord = $this->getCoord($screen, [$j, $i]);
                if (!is_null($coord)) {
                    echo $coord[2];
                } else {
                    echo ".";
                }
            }
            echo PHP_EOL;
        }
        echo "score: " . $score . PHP_EOL;
    }

}