<?php

$input = file_get_contents(__DIR__ . '/input.txt', 'r');
$input = explode(',', $input);

$input[1] = 12;
$input[2] = 2;


for ($i = 0; $i < count($input); $i += 4) {
    if ((int)$input[$i] == 99) {
        break;
    } elseif ((int)$input[$i] == 1) {
        $input[$input[$i+3]] = (int)$input[$input[$i+1]] + (int)$input[$input[$i+2]];
    } elseif ((int)$input[$i] == 2) {
        $input[$input[$i+3]] = (int)$input[$input[$i+1]] * (int)$input[$input[$i+2]];
    }
}

var_dump($input[0]);
exit;
