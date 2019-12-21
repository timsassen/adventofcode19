<?php

include_once __DIR__ . '/../vendor/autoload.php';
$code = file_get_contents(__DIR__ . '/input.txt');
$code = explode(',', $code);
$code = array_map(function ($string) {
    return (int)$string;
}, $code);

$code[0] = 2;

$arcade = new \AOC\Arcade($code);
$arcade->start(true);