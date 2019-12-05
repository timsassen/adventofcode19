<?php

$range = file_get_contents(__DIR__ . '/input.txt');
list($start, $end) = explode('-', $range);


function isAscending($number)
{
    $check = null;
    foreach (str_split($number) as $digit) {
        if ($check == null || $digit >= $check) {
            $check = $digit;
        } else {
            return false;
        }
    }

    return true;
}

function hasDouble($number)
{
    $str_split = str_split($number);
    $check = array_shift($str_split);
    foreach ($str_split as $digit) {
        if ($digit == $check) {
            return true;
        }
        $check = $digit;
    }

    return false;
}


//$test = '123455';
//var_dump(hasDouble($test));
//var_dump(isAscending($test));
//exit;


$range = range($start, $end);
$validPasswords = [];
foreach ($range as $value) {
    if (hasDouble($value) && isAscending($value)) {
        $validPasswords[] = $value;
    }
}

var_dump(count($validPasswords));
die;
