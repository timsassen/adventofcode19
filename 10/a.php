<?php
include_once __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');
$asteroid = new \AOC\AsteroidField($input);
$asteroid->check();
var_dump($asteroid->getMaxObservableAsteroidCount());