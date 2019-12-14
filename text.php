<?php

include_once __DIR__ . '/vendor/autoload.php';

$asteroids = [
    [0,0],
    [1,1],
    [2,2]
];

$ring = [
    [2,2]
];
$asteroidsInRing = array_filter($ring, function ($ringElement) use ($asteroids) {
    return in_array($ringElement, $asteroids);
});
var_dump($asteroidsInRing);