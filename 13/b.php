<?php

include_once __DIR__ . '/../vendor/autoload.php';
$code = file_get_contents(__DIR__ . '/input.txt');
$code = explode(',', $code);
$code = array_map(function ($string) {
    return (int)$string;
}, $code);

$code[0] = 2;


$screen = [];
$score = '-';
$frame = 0;
$returnedValues = [];
$break = 0;

$readInput = function () {
    return -1;
};

$opCode = new \AOC\InteractiveOptCode($code, [], false, $readInput);

while (true) {
    foreach ($opCode->run() as $key => $output) {
//        echo "frame " . $key;
        $returnedValues[] = $output;
        if (count($returnedValues) == 3513) {
            createPixels($returnedValues, $screen, $score);
            paint($screen, $score);
            $returnedValues = [];
        }
    }
    if ($break++ > 10000) {
        break;
    }
}

function pixelLocation($screen, $pixelType)
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

function getMeta($screen, $score, $frame, $lastInstruction)
{
    $padding = 3;
    return [
        'yStart' => findLowest($screen, 1) - $padding,
        'yEnd' => findHighest($screen, 1) + $padding,
        'xStart' => findLowest($screen, 0) - $padding,
        'xEnd' => findHighest($screen, 0) + $padding,
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

    $leftY = findLowest($screen, 1) - $padding;
    $topleft = findLowest($screen, 0) - $padding;
    for ($i = $leftY; $i <= findHighest($screen, 1) + $padding; $i++) {
        for ($j = $topleft; $j <= findHighest($screen, 0) + $padding; $j++) {
            $coord = getCoord($screen, [$j, $i]);
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