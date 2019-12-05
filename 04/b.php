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

function containsAtLeastSingleDouble($number)
{
    $str_split = str_split($number);
    $pairs = [];
    for ($i = 0; $i < count($str_split)-1; $i++) {
        $pairs[] = $str_split[$i] . $str_split[$i+1];
    }
    $pairs = array_filter($pairs, function ($digit){
        return $digit % 11 === 0;
    });
    $uniquePairs = array_count_values($pairs);
    return in_array(1, $uniquePairs);
}

//
//$test1 = '112233';
//$test2 = '123444';
//$test3 = '111122';
//
//var_dump(containsAtLeastSingleDouble($test1));
//var_dump(containsAtLeastSingleDouble($test2));
//var_dump(containsAtLeastSingleDouble($test3));
//exit;


$range = range($start, $end);
$validPasswords = [];
foreach ($range as $value) {
    if (hasDouble($value) && isAscending($value) && containsAtLeastSingleDouble($value)) {
        $validPasswords[] = $value;
    }
}

var_dump(count($validPasswords));
die;
