<?php
include_once __DIR__ . '/../vendor/autoload.php';

$code = $code = file_get_contents(__DIR__ . '/input.txt');
$code = explode(',', $code);
$code = array_map(function ($string) {
    return (int)$string;
}, $code);

$robot = new \AOC\PaintRobot(new \AOC\OptCode($code), 0, \AOC\PaintRobot::WHITE);
$robot->paint();
