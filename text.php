<?php

include_once __DIR__ . '/vendor/autoload.php';


$code = <<<TEST
109,1,204,-1,1001,100,1,100,1008,100,16,101,1006,101,0,99
TEST;
$code = explode(',', $code);
$code = array_map(function ($string) {
    return (int)$string;
}, $code);

$opCode = new \AOC\OptCode($code, [], true);
$output = $opCode->getOutput();

var_dump($output);
exit;