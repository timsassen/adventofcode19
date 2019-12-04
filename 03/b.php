<?php

$input = file_get_contents(__DIR__ . '/input.txt');

$wires = explode("\n", $input);

$wire1 = explode(",", $wires[0]);
$wire2 = explode(",", $wires[1]);

function pathFind($wire)
{
    $path = [];
    $wire1pos = [0,0];
    foreach ($wire as $pos) {
        $direction = substr($pos, 0, 1);
        $distance = substr($pos, 1, strlen($pos)-1);

        switch ($direction) {
            case 'R':
                $newpos = $wire1pos;
                for ($i = 1; $i <= $distance; $i++) {
                    $newpos[0]++;
                    $path[] = $newpos[0] . '*' . $newpos[1];
                }
                break;
            case 'L':
                $newpos = $wire1pos;
                for ($i = 1; $i <= $distance; $i++) {
                    $newpos[0]--;
                    $path[] = $newpos[0] . '*' . $newpos[1];
                }
                break;
            case 'D':
                $newpos = $wire1pos;
                for ($i = 1; $i <= $distance; $i++) {
                    $newpos[1]--;
                    $path[] = $newpos[0] . '*' . $newpos[1];
                }
                break;
            case 'U':;
                $newpos = $wire1pos;
                for ($i = 1; $i <= $distance; $i++) {
                    $newpos[1]++;
                    $path[] = $newpos[0] . '*' . $newpos[1];
                }
                break;
        }

        $wire1pos = $newpos;
    }

    return $path;
}

$wire1Path = pathFind($wire1);
$wire2Path = pathFind($wire2);
$crossings = array_intersect($wire1Path, $wire2Path);

function trace($wire, $crossing)
{
    $steps = 0;
    $wire1pos = [0,0];
    foreach ($wire as $pos) {
        $direction = substr($pos, 0, 1);
        $distance = substr($pos, 1, strlen($pos)-1);

        switch ($direction) {
            case 'R':
                $newpos = $wire1pos;
                for ($i = 1; $i <= $distance; $i++) {
                    $newpos[0]++;
                    $step = $newpos[0] . '*' . $newpos[1];
                    $steps++;

                    if ($step == $crossing){
                        return $steps;
                    }
                }
                break;
            case 'L':
                $newpos = $wire1pos;
                for ($i = 1; $i <= $distance; $i++) {
                    $newpos[0]--;
                    $step = $newpos[0] . '*' . $newpos[1];
                    $steps++;

                    if ($step == $crossing){
                        return $steps;
                    }
                }
                break;
            case 'D':
                $newpos = $wire1pos;
                for ($i = 1; $i <= $distance; $i++) {
                    $newpos[1]--;
                    $step = $newpos[0] . '*' . $newpos[1];
                    $steps++;

                    if ($step == $crossing){
                        return $steps;
                    }
                }
                break;
            case 'U':;
                $newpos = $wire1pos;
                for ($i = 1; $i <= $distance; $i++) {
                    $newpos[1]++;
                    $step = $newpos[0] . '*' . $newpos[1];
                    $steps++;

                    if ($step == $crossing){
                        return $steps;
                    }
                }
                break;
        }



        $wire1pos = $newpos;
    }
    throw new \Exception('ow no');
}

$lowestTrace = null;

foreach ($crossings as $crossing) {
    $wire1Trace = trace($wire1, $crossing);
    $wire2Trace = trace($wire2, $crossing);
    $lowestTrace = ((abs($wire1Trace)+abs($wire2Trace)) < $lowestTrace || is_null($lowestTrace)) ? (abs($wire1Trace)+abs($wire2Trace)) : $lowestTrace;
}
var_dump($lowestTrace);
exit;

