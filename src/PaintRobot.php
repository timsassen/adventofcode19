<?php

namespace AOC;

/**
 * Class PaintRobot
 * @package AOC
 */
class PaintRobot
{
    const BLACK = 0;
    const WHITE = 1;
    const TURNLEFT = 0;
    const TURNRIGHT = 1;

    const NORTH = "N";
    const EAST = "E";
    const SOUTH = "S";
    const WEST = "W";

    /**
     * @var OptCode|null
     */
    protected $opCode = null;
    /**
     * @var array
     */
    protected $position = null;
    /**
     * @var string
     */
    protected $direction = self::NORTH;
    /**
     * @var array
     */
    protected $paintedPanels = [];
    /**
     * @var bool
     */
    protected $verbose;

    /**
     * PaintRobot constructor.
     * @param OptCode $opCode
     * @param bool $verbose
     * @param int $startOn
     */
    public function __construct(OptCode $opCode, $verbose = false, $startOn = self::BLACK)
    {
        $this->opCode = $opCode;
        $this->verbose = $verbose;
        $this->position =  [0, 0, $startOn];
    }

    /**
     *
     */
    public function paint()
    {
        /**
         * read
         * run
         * paint
         * turn
         * move
         */

        $this->opCode->setInput([$this->position[2]]);
        if ($this->verbose) {
            var_dump("read: " . $this->position[2]);
        }
        $color = null;
        $direction = null;

        $break = 0;
        foreach ($this->opCode->run() as $key => $output) {
            if ($key % 2 == 0) {
                $color = $output;
                if ($this->verbose) {
                    var_dump("run (color): ". $color);
                }
            } elseif ($key % 2 == 1) {
                if ($this->verbose) {
                    var_dump("run (direction): ". $color);
                }
                $direction = $output;

                if (!is_null($color) && !is_null($direction)) {
                    $this->position[2] = $color;
                    $this->paintedPanels[sprintf('%sx%s', $this->position[0], $this->position[1])] = $this->position;

                    
                    if ($this->verbose) {
                        var_dump("paint: " . $color);
                    }
                    $this->move($direction);

                    $color = null;
                    $direction = null;

                    $this->opCode->setInput([$this->position[2]]);
                    if ($this->verbose) {
                        var_dump("Setting new input: " . $this->position[2]);
                    }
                }
            }
//
//            if ($break++ == 100) {
//                break;
//            }
//            sleep(1);

        }
        $this->show();
    }

    public function getPaintedPanel(array $coords = [])
    {
        $paintedPanels = array_filter($this->paintedPanels, function ($panel) use ($coords) {
            return ($coords[0] == $panel[0] && $coords[1] == $panel[1]);
        });

        return (!empty($paintedPanels)) ? max($paintedPanels) : null;
    }


    /**
     * @param $direction
     * @return null|string
     */
    public function turn($direction)
    {
        $newDirection = null;
        if ($direction == self::TURNLEFT) {
            if ($this->verbose) {
                var_dump("Turning left");
            }
            switch ($this->direction) {
                case self::NORTH:
                    $newDirection = self::WEST;
                    break;
                case self::EAST:
                    $newDirection = self::NORTH;
                    break;
                case self::SOUTH:
                    $newDirection = self::EAST;
                    break;
                case self::WEST:
                    $newDirection = self::SOUTH;
                    break;
            }
        } elseif ($direction == self::TURNRIGHT) {
            if ($this->verbose) {
                var_dump("Turning right");
            }
            switch ($this->direction) {
                case self::NORTH:
                    $newDirection = self::EAST;
                    break;
                case self::EAST:
                    $newDirection = self::SOUTH;
                    break;
                case self::SOUTH:
                    $newDirection = self::WEST;
                    break;
                case self::WEST:
                    $newDirection = self::NORTH;
                    break;
            }
        }
        return $newDirection;
    }

    /**
     * @param $direction
     */
    public function move($direction)
    {
        $newDirection = $this->turn($direction);
        if ($this->verbose) {
            var_dump("Setting direction to: ". $newDirection);
        }

        $newPosition = $this->position;
        switch ($newDirection) {
            case self::NORTH:
                $newPosition[1]--;
                break;
            case self::EAST:
                $newPosition[0]++;
                break;
            case self::SOUTH:
                $newPosition[1]++;
                break;
            case self::WEST:
                $newPosition[0]--;
                break;
        }

        $paintedPanel = $this->getPaintedPanel($newPosition);
        if (!is_null($paintedPanel)) {
            $this->position = $paintedPanel;
//            var_dump("painted panel: ");
//            var_dump($paintedPanel);
//            die;
        } else {
            $newPosition[2] = 0;
            $this->position = $newPosition;
        }

        $this->direction = $newDirection;
        if ($this->verbose) {
            var_dump("Moved: " . $newDirection . " to position: " . $this->position[0] . ','. $this->position[1]);
        }
    }

    /**
     * @return int
     */
    public function countPaintedPanels()
    {
        return count($this->paintedPanels);
    }
    
    public function findLowest($axis)
    {
        $lowest = null;
        foreach ($this->paintedPanels as $paintedPanel) {
            $lowest = ($lowest == null || $paintedPanel[$axis] < $lowest) ? $paintedPanel[$axis] : $lowest;
        }
        return $lowest;
    }
    
    public function findHighest($axis)
    {
        $highest = null;
        foreach ($this->paintedPanels as $paintedPanel) {
            $highest = ($highest == null || $paintedPanel[$axis] > $highest) ? $paintedPanel[$axis] : $highest;
        }
        return $highest;
    }

    public function show()
    {
        $padding = 3;
        for ($i = $this->findLowest(1) - $padding; $i <= $this->findHighest(1) + $padding; $i++) {
            for ($j = $this->findLowest(0) - $padding; $j <= $this->findHighest(0) + $padding; $j++) {
                if ($j == $this->position[0] && $i == $this->position[1]) {
                    switch ($this->direction) {
                        case self::NORTH:
                            echo "^";
                            break;
                        case self::EAST:
                            echo ">";
                            break;
                        case self::SOUTH:
                            echo "v";
                            break;
                        case self::WEST:
                            echo "<";
                            break;
                    }
                    continue;

                } else {
                    $paintedPanel = $this->getPaintedPanel([$j, $i]);
                    if (!is_null($paintedPanel)) {
                        echo $paintedPanel[2] == 1 ? '#' : '.';
                    } else {
//                        echo abs($j);
                        echo ".";
                    }
                }
            }
            echo PHP_EOL;
        }
    }
}