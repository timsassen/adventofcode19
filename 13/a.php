<?php

include_once __DIR__ . '/../vendor/autoload.php';
$code = file_get_contents(__DIR__ . '/input.txt');
$code = explode(',', $code);
$code = array_map(function ($string) {
    return (int)$string;
}, $code);

$opCode = new \AOC\OptCode($code);
$screen = [];
$returnedValues = [];
foreach ($opCode->run() as $key => $output) {
    $returnedValues[] = $output;
}

$pixels = array_chunk($returnedValues, 3);
foreach ($pixels as $pixel) {
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
    $screen[sprintf("%s-%s" , $pixel[0], $pixel[1])] = [$pixel[0], $pixel[1], $type];
}

function findLowest($screen, $axis)
{
    $lowest = null;
    foreach ($screen as $pixel) {
        $lowest = ($lowest == null || $pixel[$axis] < $lowest) ? $pixel[$axis] : $lowest;
    }
    return $lowest;
}

function findHighest($screen, $axis)
{
    $highest = null;
    foreach ($screen as $pixel) {
        $highest = ($highest == null || $pixel[$axis] > $highest) ? $pixel[$axis] : $highest;
    }
    return $highest;
}

function getCoord(array $screen = [], array $coords = [])
{
    return (isset($screen[sprintf("%s-%s" , $coords[0], $coords[1])]))
        ? $screen[sprintf("%s-%s" , $coords[0], $coords[1])]
        : null;
}

var_dump(count(array_filter($screen, function ($pixel) { return $pixel[2] == '◊';})));

$padding = 3;
$test = false;
for ($i = findLowest($screen, 1) - $padding; $i <= findHighest($screen, 1) + $padding; $i++) {
    for ($j = findLowest($screen, 0) - $padding; $j <= findHighest($screen, 0) + $padding; $j++) {
        $coord = getCoord($screen, [$j, $i]);
        if (!is_null($coord)) {
            echo $coord[2];
        } else {
            echo ".";
        }
    }
    echo PHP_EOL;
}
