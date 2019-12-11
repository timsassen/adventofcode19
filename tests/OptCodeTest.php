<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class OptCodeTest extends TestCase
{
    public function testday2a()
    {
        $code = file_get_contents(__DIR__ . '/../02/input.txt');
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $code[1] = 12;
        $code[2] = 2;

        $opCode = new \AOC\OptCode($code, []);
        try {
            $opCode->run();
        } catch (\AOC\HaltException $e) {
            $zeroAddress = $opCode->readAt(0);
        }

        $this->assertEquals(3562624, $zeroAddress);
    }

    public function testday2()
    {
        $code = file_get_contents(__DIR__ . '/../02/input.txt');
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);


        for($i = 0; $i <= 99; $i++) {
            for($j = 0; $j <= 99; $j++) {
                $code[1] = $i;
                $code[2] = $j;
                $opCode = new \AOC\OptCode($code, []);
                try {
                    $opCode->run();
                } catch (\AOC\HaltException $e) {
                    $output = $opCode->readAt(0);
                }
                if ($output == 19690720) {
                    $check = 100 * $i + $j;
                    $this->assertEquals(8298, $check);
                }
            }
        }
    }

    public function testday5a()
    {
        $code = file_get_contents(__DIR__ . '/../05/input.txt');

        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code, [1]);
        try {
            $output = $opCode->run();

        } catch (\AOC\HaltException $e) {
            $output = $e->getLastOutput();
        }

        $this->assertEquals(7566643, $output);
    }

    public function testday5example1()
    {
        $testinput = <<<TEST
3,21,1008,21,8,20,1005,20,22,107,8,21,20,1006,20,31,1106,0,36,98,0,0,1002,21,125,20,4,20,1105,1,46,104,999,1105,1,46,1101,1000,1,20,4,20,1105,1,46,98,99
TEST;
        $code = explode(',', $testinput);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code, [7]);
        $belowEight = $opCode->run();
        $this->assertEquals(999, $belowEight);
    }

    public function testday5example2()
    {
        $testinput = <<<TEST
3,21,1008,21,8,20,1005,20,22,107,8,21,20,1006,20,31,1106,0,36,98,0,0,1002,21,125,20,4,20,1105,1,46,104,999,1105,1,46,1101,1000,1,20,4,20,1105,1,46,98,99
TEST;
        $code = explode(',', $testinput);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code, [8]);
        $eight = $opCode->run();
        $this->assertEquals(1000, $eight);
    }

    public function testday5example3()
    {
        $testinput = <<<TEST
3,21,1008,21,8,20,1005,20,22,107,8,21,20,1006,20,31,1106,0,36,98,0,0,1002,21,125,20,4,20,1105,1,46,104,999,1105,1,46,1101,1000,1,20,4,20,1105,1,46,98,99
TEST;
        $code = explode(',', $testinput);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code, [9]);
        $eight = $opCode->run();
        $this->assertEquals(1001, $eight);
    }

    public function testday5example4()
    {
        $testinput = <<<TEST
3,12,6,12,15,1,13,14,13,4,13,99,-1,0,1,9
TEST;
        $code = explode(',', $testinput);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code, [0]);
        try {
            $eight =  $opCode->run();
            $this->assertEquals(0, $eight);
        } catch (\AOC\HaltException $e) {
            $eight = $e->getLastOutput();
            $this->assertEquals(0, $eight);
        }
    }


    public function testday5example5()
    {
        $testinput = <<<TEST
3,12,6,12,15,1,13,14,13,4,13,99,-1,0,1,9
TEST;
        $code = explode(',', $testinput);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code, [123]);
        $eight = $opCode->run();
        $this->assertEquals(1, $eight);
    }

    public function testday5b()
    {
        $code = file_get_contents(__DIR__ . '/../05/input.txt');

        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code, [5]);
        $output = $opCode->run();
        $this->assertEquals(9265694, $output);
    }
//
//    public function testday9quine()
//    {
//        $code = <<<TEST
//109,1,204,-1,1001,100,1,100,1008,100,16,101,1006,101,0,99
//TEST;
//        $code = explode(',', $code);
//        $code = array_map(function ($string) {
//            return (int)$string;
//        }, $code);
//
//        $opCode = new \AOC\OptCode($code);
//        try {
//            $output = $opCode->run();
//        } catch (\AOC\HaltException $e) {
//            $output = $e->getLastOutput();
//        }
//
//        var_dump($output);
//    }

    public function testday9largememoryaddition()
    {
        $code = <<<TEST
1101,1,2,15,4,15,99
TEST;
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code);
        try {
            $output = $opCode->run();
        } catch (\AOC\HaltException $e) {
            $output = $e->getLastOutput();
        }

        $this->assertEquals(16, count($opCode->getCode()));
        $this->assertEquals(3, $output);
    }

    public function testday9largememorymulti()
    {
        $code = <<<TEST
1102,1,2,199,4,199,99
TEST;
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code);
        try {
            $output = $opCode->run();
        } catch (\AOC\HaltException $e) {
            $output = $e->getLastOutput();
        }

        $this->assertEquals(200, count($opCode->getCode()));
        $this->assertEquals(2, $output);
    }

    public function testday9largememorymulti2()
    {
        $code = <<<TEST
1002,199,2,500,4,500,99
TEST;
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code);
        try {
            $output = $opCode->run();
        } catch (\AOC\HaltException $e) {
            $output = $e->getLastOutput();
        }

        $this->assertEquals(0, $output);
        $this->assertEquals(501, count($opCode->getCode()));
    }

    public function testday9example2()
    {
        $code = <<<TEST
1102,34915192,34915192,7,4,7,99,0
TEST;
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code);
        try {
            $output = $opCode->run();
        } catch (\AOC\HaltException $e) {
            $output = $e->getLastOutput();
        }
        $this->assertEquals(1219070632396864, $output);
    }

    public function testday9example3()
    {
        $code = <<<TEST
104,1125899906842624,99
TEST;
        $code = explode(',', $code);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);

        $opCode = new \AOC\OptCode($code);
        try {
            $output = $opCode->run();
        } catch (\AOC\HaltException $e) {
            $output = $e->getLastOutput();
        }
        $this->assertEquals(1125899906842624, $output);
    }
}
