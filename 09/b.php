<?php

include_once __DIR__ . '/../vendor/autoload.php';
$code = file_get_contents(__DIR__ . '/input.txt');
$code = explode(',', $code);
$code = array_map(function ($string) {
    return (int)$string;
}, $code);

$opCode = new \AOC\OptCode($code, [2]);
$output = $opCode->getOutput();
var_dump($output);
exit;