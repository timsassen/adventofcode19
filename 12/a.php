<?php
include_once __DIR__ . '/../vendor/autoload.php';
$input = file_get_contents(__DIR__ . '/input.txt');

$moonRows = explode(PHP_EOL, $input);
$names = ['Io', 'Europa', 'Ganymede', 'Callisto'];
$moons = [];
foreach ($moonRows as $key => $moonRow) {
    preg_match('/^<x=(-?\d*), y=(-?\d*), z=(-?\d*)>$/', $moonRow, $matches);
    array_shift($matches);
    $moons[] = new \AOC\Moon($names[$key], (int)$matches[0], (int)$matches[1], (int)$matches[2]);
}

$jupiter = new \AOC\Jupiter($moons);

$timeSteps = 1000;
for ($i = 1; $i <= $timeSteps; $i++) {
    $jupiter->applyGravity();
    $jupiter->applyVelocity();
}

var_dump($jupiter->getTotalEnergy());

