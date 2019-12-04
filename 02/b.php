<?php

function calc($noun, $verb) {
    $input = file_get_contents(__DIR__ . '/input.txt', 'r');
    $input = explode(',', $input);

    $input[1] = $noun;
    $input[2] = $verb;

    for ($i = 0; $i < count($input); $i += 4) {
        if ((int)$input[$i] == 99) {
            break;
        } elseif ((int)$input[$i] == 1) {
            $input[$input[$i+3]] = (int)$input[$input[$i+1]] + (int)$input[$input[$i+2]];
        } elseif ((int)$input[$i] == 2) {
            $input[$input[$i+3]] = (int)$input[$input[$i+1]] * (int)$input[$input[$i+2]];
        }
    }

    return $input[0];
}

for($i = 0; $i <= 99; $i++) {
    for($j = 0; $j <= 99; $j++) {
        $output = calc($i, $j);
        if ($output == 19690720) {
            echo 100 * $i + $j;
            exit;
        }
    }
}

