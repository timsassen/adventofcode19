<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = str_split($input);

$width = 25;
$height = 6;

$layers = [];
while (!empty($input)) {
    $layers[] = array_splice($input, 0, ($width * $height));
}

$layerCount = [];
foreach ($layers as $layer) {
    $counts = array_count_values($layer);
    $layerCount[$counts[0]] = $counts[1] * $counts[2];
}

ksort($layerCount);
$lowestZeroCount = array_shift($layerCount);
var_dump($lowestZeroCount);
exit;
