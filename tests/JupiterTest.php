<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class JupiterTest extends TestCase
{
    public function testDay12example1()
    {
        $input = <<<INPUT
<x=-1, y=0, z=2>
<x=2, y=-10, z=-7>
<x=4, y=-8, z=8>
<x=3, y=5, z=-1>
INPUT;
        $moonRows = explode(PHP_EOL, $input);
        $names = ['Io', 'Europa', 'Ganymede', 'Callisto'];
        $moons = [];
        foreach ($moonRows as $key => $moonRow) {
            preg_match('/^<x=(-?\d*), y=(-?\d*), z=(-?\d*)>$/', $moonRow, $matches);
            array_shift($matches);
            $moons[] = new \AOC\Moon($names[$key], (int)$matches[0], (int)$matches[1], (int)$matches[2]);
        }

        $jupiter = new \AOC\Jupiter($moons);

        $timeSteps = 10;
        for ($i = 1; $i <= $timeSteps; $i++) {
            $jupiter->applyGravity();
            $jupiter->applyVelocity();
        }

        $this->assertEquals(179, $jupiter->getTotalEnergy());
    }

    public function testDay12example2()
    {
        $input = <<<INPUT
<x=-8, y=-10, z=0>
<x=5, y=5, z=10>
<x=2, y=-7, z=3>
<x=9, y=-8, z=-3>
INPUT;
        $moonRows = explode(PHP_EOL, $input);
        $names = ['Io', 'Europa', 'Ganymede', 'Callisto'];
        $moons = [];
        foreach ($moonRows as $key => $moonRow) {
            preg_match('/^<x=(-?\d*), y=(-?\d*), z=(-?\d*)>$/', $moonRow, $matches);
            array_shift($matches);
            $moons[] = new \AOC\Moon($names[$key], (int)$matches[0], (int)$matches[1], (int)$matches[2]);
        }

        $jupiter = new \AOC\Jupiter($moons);

        $timeSteps = 100;
        for ($i = 1; $i <= $timeSteps; $i++) {
            $jupiter->applyGravity();
            $jupiter->applyVelocity();
        }

        $this->assertEquals(1940, $jupiter->getTotalEnergy());
    }

    public function testOptimizedExample1()
    {
        $input = <<<INPUT
<x=-1, y=0, z=2>
<x=2, y=-10, z=-7>
<x=4, y=-8, z=8>
<x=3, y=5, z=-1>
INPUT;
        $moonRows = explode(PHP_EOL, $input);
        $names = ['Io', 'Europa', 'Ganymede', 'Callisto'];
        $moons = [];
        foreach ($moonRows as $key => $moonRow) {
            preg_match('/^<x=(-?\d*), y=(-?\d*), z=(-?\d*)>$/', $moonRow, $matches);
            array_shift($matches);
            $moons[] = new \AOC\Moon($names[$key], (int)$matches[0], (int)$matches[1], (int)$matches[2]);
        }

        $jupiter = new \AOC\Jupiter($moons);

        $timeSteps = 10;
        for ($i = 1; $i <= $timeSteps; $i++) {
            $jupiter->optimizedGravityPlusVelocity('x');
            $jupiter->optimizedGravityPlusVelocity('y');
            $jupiter->optimizedGravityPlusVelocity('z');
        }

        $this->assertEquals(179, $jupiter->getTotalEnergy());
    }

    public function testOptimizedExample2()
    {
        $input = <<<INPUT
<x=-8, y=-10, z=0>
<x=5, y=5, z=10>
<x=2, y=-7, z=3>
<x=9, y=-8, z=-3>
INPUT;
        $moonRows = explode(PHP_EOL, $input);
        $names = ['Io', 'Europa', 'Ganymede', 'Callisto'];
        $moons = [];
        foreach ($moonRows as $key => $moonRow) {
            preg_match('/^<x=(-?\d*), y=(-?\d*), z=(-?\d*)>$/', $moonRow, $matches);
            array_shift($matches);
            $moons[] = new \AOC\Moon($names[$key], (int)$matches[0], (int)$matches[1], (int)$matches[2]);
        }

        $jupiter = new \AOC\Jupiter($moons);

        $timeSteps = 100;
        for ($i = 1; $i <= $timeSteps; $i++) {
            $jupiter->optimizedGravityPlusVelocity('x');
            $jupiter->optimizedGravityPlusVelocity('y');
            $jupiter->optimizedGravityPlusVelocity('z');
        }

        $this->assertEquals(1940, $jupiter->getTotalEnergy());
    }
}