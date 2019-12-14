<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 14-12-19
 * Time: 10:45
 */

use PHPUnit\Framework\TestCase;

class AstroidFieldTest extends TestCase
{
    public function testDimensions()
    {
        $input = <<<ASTROID
......#.#.
#..#.#....
..#######.
.#.#.###..
.#..#.....
..#....#.#
#..#....#.
.##.#..###
##...#..#.
.#....####
ASTROID;

        $astroid = new \AOC\AsteroidField($input);
        $this->assertCount(40, $astroid->getAsteroids());
        $this->assertEquals(10, $astroid->getHeight());
        $this->assertEquals(10, $astroid->getWidth());
    }

    public function testRing1()
    {
        $input = <<<ASTROID
.....
.....
..#..
.....
.....
ASTROID;

        $astroid = new \AOC\AsteroidField($input);
        $ring = $astroid->createRing(2, [2, 2]);
        $this->assertEquals([
            //left
            [0, 2],
            // up
            [0, 1],
            [0, 0],
            //right
            [1, 0],
            [2, 0],
            [3, 0],
            [4, 0],
            //down
            [4, 1],
            [4, 2],
            [4, 3],
            [4, 4],
            //left
            [3, 4],
            [2, 4],
            [1, 4],
            [0, 4],
            //up again
            [0, 3],

        ], $ring);
    }

    public function testRing2()
    {
        $input = <<<ASTROID
...
.#.
...
ASTROID;

        $asteroid = new \AOC\AsteroidField($input);
        $ring = $asteroid->createRing(1, [1, 1]);
        $this->assertEquals([
            //left
            [0, 1],
            // up
            [0, 0],
            //right
            [1, 0],
            [2, 0],
            //down
            [2, 1],
            [2, 2],
            //left
            [1, 2],
            [0, 2],
        ], $ring);
    }

    public function testSemiRing()
    {
        $input = <<<ASTROID
#..
...
...
ASTROID;

        $asteroid = new \AOC\AsteroidField($input);
        $ring = $asteroid->createRing(1, [0, 0]);
        $this->assertEquals([
            [1,0],
            [1,1],
            [0,1]
        ], $ring);
    }

    public function testRing3()
    {
        $input = <<<ASTROID
.......
.......
.......
...#...
.......
.......
.......
ASTROID;

        $astroid = new \AOC\AsteroidField($input);
        $ring = $astroid->createRing(3, [3, 3]);
        $this->assertEquals([
            //left
            [0, 3],
            // up
            [0, 2],
            [0, 1],
            [0, 0],
            //right
            [1, 0],
            [2, 0],
            [3, 0],
            [4, 0],
            [5, 0],
            [6, 0],
            //down
            [6, 1],
            [6, 2],
            [6, 3],
            [6, 4],
            [6, 5],
            [6, 6],
            //left
            [5, 6],
            [4, 6],
            [3, 6],
            [2, 6],
            [1, 6],
            [0, 6],
            //up again
            [0, 5],
            [0, 4]
        ], $ring);
    }
}
