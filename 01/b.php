<?php

$inputFile = __DIR__ . '/input.txt';
$input = fopen($inputFile, 'r');
function calculateFuel($mass) {
    return floor($mass/3)-2;
}
function calculateFuelFuel($fuelMass)
{
    $fuelfuel = 0;
    $extraFuel = $fuelMass;
    while ($extraFuel > 6) {
        $extraFuel = calculateFuel($extraFuel);
        $fuelfuel += $extraFuel;
    }
    return $fuelfuel;

}
$totalFuel = 0;
while ($line = fgets($input)) {
    $fuel = calculateFuel((int) $line);
    $fuelfuel = calculateFuelFuel($fuel);
    $totalFuel += ($fuel + $fuelfuel);
}
fclose($input);
var_dump($totalFuel);


//$fueltest1 = calculateFuel(1969);
//$fuelfueltest1 = calculateFuelFuel($fueltest1);
//// should be 966
//var_dump($fueltest1+$fuelfueltest1);
//
//$fueltest2 = calculateFuel(100756);
//$fuelfueltest2 = calculateFuelFuel($fueltest2);
//// should be 50346
//var_dump($fueltest2 + $fuelfueltest2);