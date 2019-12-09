<?php

include_once __DIR__ . '/../vendor/autoload.php';
$opCode = new \AOC\OptCode(__DIR__ . '/input.txt', 1, true);
$res = $opCode->run();
if ($res != 0) {
    var_dump($res);
    exit;
}