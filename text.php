<?php

include_once __DIR__ . '/vendor/autoload.php';

$test = <<<CODE
3,26,1001,26,-4,26,3,27,1002,27,2,27,1,27,26,27,4,27,1001,28,-1,28,1005,28,6,99,0,0,5
CODE;
$code = explode(',', $test);
$code = array_map(function ($string) {
    return (int)$string;
}, $code);

$feedback = new \AOC\AmplifierFeedbackArray($code);
$thrust = $feedback->tryPermutation([9,8,7,6,5]);

var_dump($thrust);die;