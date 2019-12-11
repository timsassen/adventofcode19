<?php

include_once __DIR__ . '/../vendor/autoload.php';
$code = <<<INPUT
1102,34915192,34915192,7,4,7,99,0
INPUT;
$code = explode(',', $code);
$code = array_map(function ($string) {
    return (int)$string;
}, $code);

$opCode = new \AOC\OptCode($code);
try {
    $output = $opCode->run();
} catch (\AOC\HaltException $e) {
    $output = $e->getLastOutput();
}
var_dump($output);
exit;