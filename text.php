<?php

include_once __DIR__ . '/vendor/autoload.php';

$input = <<<ASTEROID
.#....#####...#..
##...##.#####..##
##...#...#.#####.
..#.....#...###..
..#.#.....#....##
ASTEROID;

$asteroid = new \AOC\AsteroidField($input);
//        $asteroid->check();
//        $optCoords = $asteroid->getOptimalLocationCoords();
$vaporizedAsteroids = $asteroid->vaporize();