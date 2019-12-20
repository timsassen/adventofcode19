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
$client->flushall();
$jupiter = new \AOC\Jupiter($moons);
$steps = 0;
$client->hset('hash', $steps+1, $jupiter->getState());

while (true) {
    $jupiter->applyGravity();
    $jupiter->applyVelocity();
    $newState = $jupiter->getState();
    $steps++;

    if ($client->hexists('hash', $newState)) {
        break;
    } else {
        $client->hset('hash', $steps+1, $newState);
    }
}

var_dump($steps);


