<?php

include_once __DIR__ . '/vendor/autoload.php';

$input = <<<ASTROID
...
.#.
...
ASTROID;

$asteroid = new \AOC\AsteroidField($input);
$ring = $asteroid->createRing(1, [1,1]);

$input = <<<ASTROID
.....
.....
..#..
.....
.....
ASTROID;

$asteroid = new \AOC\AsteroidField($input);
$ring = $asteroid->createRing(2, [2,2]);

exit;
