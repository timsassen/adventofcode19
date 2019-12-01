<?php

$inputFile = __DIR__ . '/input.txt';
$input = fopen($inputFile, 'r');
function calculateFuel($mass) {
    return floor($mass/3)-2;
}
$fuel = 0;
while ($line = fgets($input)) {
    $fuel += calculateFuel((int) $line);
}
fclose($input);

var_dump($fuel);