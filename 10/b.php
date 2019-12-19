<?php
include_once __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');
$asteroid = new \AOC\AsteroidField($input);

$vaporizedAsteroids = $asteroid->vaporize();

$twoHundrethAsteroid = $vaporizedAsteroids[199];
var_dump($twoHundrethAsteroid[0] * 100 + $twoHundrethAsteroid[1]);
