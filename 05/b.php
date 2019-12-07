<?php

$code = file_get_contents(__DIR__ . '/input.txt');

$code = explode(',', $code);
$code = array_map(function ($string) {
    return (int)$string;
    }, $code);
$code = new ArrayIterator($code);


function halt()
{
    var_dump('halt');
}

function parseInstruction($value)
{
    $instruction = substr($value, strlen($value)-2, 2);
    $modes = substr($value, 0, strlen($value)-2);
    $modes = str_split($modes);
    $modes = array_reverse($modes);
    $returnModes = [0,0,0];
    foreach ($returnModes as $key => $returnMode) {
        if (isset($modes[$key])) {
            $returnModes[$key] = (int)$modes[$key];
        }
    }
    return [
        $instruction => $returnModes
    ];
}

function run($code, $instructionType, $parameter1, $parameter2 = null, $parameter3 = null, $modes = [0,0,0])
{

    if ($instructionType == 1) {
        $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
        $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
        var_dump(sprintf("Add %s to %s and set to position %s", $parameter1, $parameter2, $parameter3));
        $code[$parameter3] = $parameter1 + $parameter2;
    } elseif ($instructionType == 2) {
        $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
        $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
        var_dump(sprintf("Multiply %s with %s and set to position %s", $parameter1, $parameter2, $parameter3));
        $code[$parameter3] = $parameter1 * $parameter2;
    } elseif ($instructionType == 3) {
        $input = 5;
        var_dump(sprintf("Set input %s to position %s", $input, $parameter1));
        $code[$parameter1] = $input;
    } elseif ($instructionType == 4) {
        var_dump(sprintf("Output %s from position %s", ($modes[0] === 0) ? $code[$parameter1] : $parameter1, $parameter1));
        return ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
    } elseif ($instructionType == 5) {
        $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
        $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
        if ($parameter1 !== 0) {
            var_dump(sprintf("5: New pointer is %s", $parameter2));
            return $parameter2;
        }
        return null;
    } elseif ($instructionType == 6) {
        $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
        $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
        if ($parameter1 === 0) {
            var_dump(sprintf("6: New pointer is %s", $parameter2));
            return $parameter2;
        }
        return null;
    } elseif ($instructionType == 7) {
        $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
        $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
        var_dump(sprintf("If %s is less than %s, set 1 to position %s", $parameter1, $parameter2, $parameter3));
        $code[$parameter3] = $parameter1 < $parameter2 ? 1 : 0;
    } elseif ($instructionType == 8) {
        $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
        $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
        var_dump(sprintf("If %s is equal to %s, set 1 to position %s", $parameter1, $parameter2, $parameter3));
        $code[$parameter3] = $parameter1 === $parameter2 ? 1 : 0;
    }


    return false;
}

foreach ($code as $i => $instructionType)
{
//    var_dump($i . " => " . $instructionType);
    if ($instructionType == 99) {
        halt();
        break;
    }

    if ($instructionType > 4 && strlen($instructionType) > 2)  {
        $instruction = parseInstruction($instructionType);
        $instructionType = (int)key($instruction);
        $modes = current($instruction);
        $parameter1 = (int)$code[$i+1];
        $parameter2 = (in_array($instructionType, [1,2,5,6,7,8])) ? (int)$code[$i+2] : null;
        $parameter3 = (in_array($instructionType, [1,2,7,8])) ? (int)$code[$i+3] : null;

        try {
            $currentOutput = run($code, $instructionType, $parameter1, $parameter2, $parameter3, $modes);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    } else {
        try {
            $currentOutput = run($code, $instructionType, (int)$code[$i+1], (int)$code[$i+2], (int)$code[$i+3]);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    if ($instructionType == 4 && $currentOutput != 0) {
        var_dump($currentOutput);
        exit;
    }

    if (in_array($instructionType, [3,4,99])) {
        $code->seek($i + 1);
    } elseif (in_array($instructionType, [5,6])) {
        $newPointer = $currentOutput;
        if (null !== $newPointer) {
            $code->seek($newPointer-1);
        } else {
            $code->seek($i + 2);
        }
    }elseif (in_array($instructionType, [1,2,7,8])) {
        $code->seek($i + 3);
    }
}