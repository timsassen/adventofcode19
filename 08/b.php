<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = str_split($input);

$width = 25;
$height = 6;

$layers = [];
while (!empty($input)) {
    $layers[] = array_splice($input, 0, ($width * $height));
}

$overlay = [];
foreach ($layers as $layer) {
    for ($i = 0; $i < 150; $i++) {
        $overlay[$i] = (!isset($overlay[$i]) || $overlay[$i] == '2') ? $layer[$i] : $overlay[$i];
    }
}

foreach ($overlay as $key => $item) {
    echo $item == 0 ? ' ' : '#';
    if ($key % 25 == 0) {
        echo PHP_EOL;
    }
}
echo PHP_EOL;