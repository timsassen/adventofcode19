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

$client = \Symfony\Component\Cache\Adapter\RedisAdapter::createConnection('redis://0.0.0.0:6379');
$jupiter = new \AOC\Jupiter($moons);


$dimension = $argv[1];
$hashName = 'hash'.$dimension;
$steps = 0;
$states[] = $jupiter->getDimensionState($dimension);

while (true) {
    $jupiter->optimizedGravityPlusVelocity($dimension);
    $newState = $jupiter->getDimensionState($dimension);
    $steps++;
    if (in_array($newState, $states)) {
        break;
    } else {
        $states[] = $newState;
    }
}

//x 84032
//y 161428
//z 231614

var_dump($steps);


