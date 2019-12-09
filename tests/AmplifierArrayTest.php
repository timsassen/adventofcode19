<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class AmplifierArrayTest extends TestCase
{
    public function testExample1()
    {
        $code = '3,15,3,16,1002,16,10,16,1,16,15,15,4,15,99,0,0';
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $amplifierArray = new \AOC\AmplifierArray($code);
        $thrust = $amplifierArray->tryPermutation([4,3,2,1,0]);

        $this->assertEquals(43210, $thrust);
    }

    public function testExample2()
    {
        $code = '3,23,3,24,1002,24,10,24,1002,23,-1,23,101,5,23,23,1,24,23,23,4,23,99,0,0';
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $amplifierArray = new \AOC\AmplifierArray($code);
        $thrust = $amplifierArray->tryPermutation([0,1,2,3,4]);

        $this->assertEquals(54321, $thrust);
    }

    public function testExample3()
    {
        $code = '3,31,3,32,1002,32,10,32,1001,31,-2,31,1007,31,0,33,1002,33,7,33,1,33,31,31,1,32,31,31,4,31,99,0,0,0';
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $amplifierArray = new \AOC\AmplifierArray($code);
        $thrust = $amplifierArray->tryPermutation([1,0,4,3,2]);

        $this->assertEquals(65210, $thrust);
    }

    public function testday7a()
    {
        $code = file_get_contents(__DIR__ . '/../07/input.txt');
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $amplifierArray = new \AOC\AmplifierArray($code);
        $this->assertEquals(118936, $amplifierArray->getMaxOutput());
    }
}