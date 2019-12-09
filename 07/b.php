<?php
include_once __DIR__ . '/../vendor/autoload.php';

$code = file_get_contents(__DIR__ . '/input.txt');
$code = explode(',', $code);
$code = array_map(function ($string) {
    return (int)$string;
}, $code);

$feedback = new \AOC\AmplifierFeedbackArray($code);
$thrust = $feedback->getMaxOutput();
var_dump($thrust);
exit;
