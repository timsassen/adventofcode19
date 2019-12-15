<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 14-12-19
 * Time: 10:45
 */

use PHPUnit\Framework\TestCase;

class ASTEROIDFieldTest extends TestCase
{
    public function testDimensions()
    {
        $input = <<<ASTEROID
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
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $this->assertCount(40, $asteroid->getAsteroids());
        $this->assertEquals(10, $asteroid->getHeight());
        $this->assertEquals(10, $asteroid->getWidth());
    }

    public function testRing1()
    {
        $input = <<<ASTEROID
.....
.....
..#..
.....
.....
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $ring = $asteroid->createRing(2, [2, 2]);
        $this->assertEquals([
            //right
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
            //up
            [0, 3],
            [0, 2],
            [0, 1],
            [0, 0],
            //right
            [1, 0],

        ], $ring);
    }

    public function testRing2()
    {
        $input = <<<ASTEROID
...
.#.
...
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $ring = $asteroid->createRing(1, [1, 1]);
        $this->assertEquals([
            //right
            [1, 0],
            [2, 0],
            //down
            [2, 1],
            [2, 2],
            //left
            [1, 2],
            [0, 2],
            [0, 1],
            // up
            [0, 0],
        ], $ring);
    }

    public function testSemiRing()
    {
        $input = <<<ASTEROID
#..
...
...
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $ring = $asteroid->createRing(1, [0, 0]);
        $this->assertEquals([
            [1, 0],
            [1, 1],
            [0, 1]
        ], $ring);
    }

    public function testRing3()
    {
        $input = <<<ASTEROID
.......
.......
.......
...#...
.......
.......
.......
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $ring = $asteroid->createRing(3, [3, 3]);
        $this->assertEquals([
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
            [0, 4],
            [0, 3],
            // up
            [0, 2],
            [0, 1],
            [0, 0],
            //right
            [1, 0],
            [2, 0]
        ], $ring);
    }

    public function testRing4()
    {
        $input = <<<ASTEROID
.......
.......
.......
...#...
.......
.......
.......
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $rings = $asteroid->getRings([3, 3]);
        $this->assertCount(3, $rings);
    }

    public function testRemoveFromList()
    {
        $input = <<<ASTEROID
.......
.......
.......
...#...
.......
.......
.......
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $this->assertEquals([3,3], $asteroid->getAsteroids()[0]);
        $asteroid->removeFromList([3,3]);
        $this->assertEmpty($asteroid->getAsteroids());
    }

    public function testobscure()
    {
        $input = <<<ASTEROID
#..
.#.
..#
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $asteroid->check();
        $this->assertEquals(2, $asteroid->getMaxObservableAsteroidCount());
    }

    public function testobscureB()
    {
        $input = <<<ASTEROID
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
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $asteroid->check();
        $this->assertEquals(33, $asteroid->getMaxObservableAsteroidCount());
    }

    public function testobscureC()
    {
        $input = <<<ASTEROID
#.#...#.#.
.###....#.
.#....#...
##.#.#.#.#
....#.#.#.
.##..###.#
..#...##..
..##....##
......#...
.####.###.
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $asteroid->check();
        $this->assertEquals(35, $asteroid->getMaxObservableAsteroidCount());
    }


    public function testobscureD()
    {
        $input = <<<ASTEROID
.#..#..###
####.###.#
....###.#.
..###.##.#
##.##.#.#.
....###..#
..#.#..#.#
#..#.#.###
.##...##.#
.....#.#..
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $asteroid->check();
        $this->assertEquals(41, $asteroid->getMaxObservableAsteroidCount());
    }


    public function testobscureE()
    {
        $input = <<<ASTEROID
.#..##.###...#######
##.############..##.
.#.######.########.#
.###.#######.####.#.
#####.##.#.##.###.##
..#####..#.#########
####################
#.####....###.#.#.##
##.#################
#####.##.###..####..
..######..##.#######
####.##.####...##..#
.#####..#.######.###
##...#.##########...
#.##########.#######
.####.#.###.###.#.##
....##.##.###..#####
.#.#.###########.###
#.#.#.#####.####.###
###.##.####.##.#..##
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $asteroid->check();
        $this->assertEquals(210, $asteroid->getMaxObservableAsteroidCount());
    }

    public function testisObscured()
    {
        $input = <<<ASTEROID
.......
.......
.......
...#...
.......
.......
.......
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $asteroid->setObscuredCoords([[0,1], [3,3]]);
        $this->assertEquals(true, $asteroid->isObscured([0,1]));
        $this->assertEquals(false, $asteroid->isObscured([0,2]));
        $this->assertEquals(true, $asteroid->isObscured([3,3]));
    }

    public function testHorizontalAlign()
    {
        $input = <<<ASTEROID
.......
.......
.......
.#.#...
.......
.......
.......
ASTEROID;
        $asteroid = new \AOC\AsteroidField($input);
        $verticalAlign = $asteroid->horizontalAlign([1, 3], [3, 3]);
        $this->assertEquals([
            [4,3],
            [5,3],
            [6,3],
        ], $verticalAlign);

        $verticalAlign = $asteroid->horizontalAlign([3, 3], [1, 3]);
        $this->assertEquals([
            [0,3]
        ], $verticalAlign);

        $verticalAlign = $asteroid->horizontalAlign([6,0], [5,0]);
        $this->assertEquals([
            [4,0],
            [3,0],
            [2,0],
            [1,0],
            [0,0],
        ], $verticalAlign);
    }

    public function testVerticalAlign()
    {
        $input = <<<ASTEROID
......#
.......
......#
.......
.......
.......
.......
ASTEROID;
        $asteroid = new \AOC\AsteroidField($input);
        $this->assertEquals([
            [6,3],
            [6,4],
            [6,5],
            [6,6],
        ], $asteroid->verticalAlign([6,0], [6,2]));

        $this->assertEmpty($asteroid->verticalAlign([6,2], [6,0]));
    }

    public function testIsOutOfBounds()
    {
        $input = <<<ASTEROID
.......
.......
.......
...#...
.......
.......
.......
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $this->assertEquals(true, $asteroid->isOutOfBounds([8,0]));
        $this->assertEquals(true, $asteroid->isOutOfBounds([0,8]));
        $this->assertEquals(true, $asteroid->isOutOfBounds([-1,0]));
        $this->assertEquals(true, $asteroid->isOutOfBounds([0,-1]));
        $this->assertEquals(false, $asteroid->isOutOfBounds([0,0]));
        $this->assertEquals(false, $asteroid->isOutOfBounds([6,6]));

    }

    public function testDiagonalAlign()
    {
        $input = <<<ASTEROID
.......
.......
....a..
.......
.......
.......
......A
ASTEROID;
        $asteroid = new \AOC\AsteroidField($input);
        $shadows = $asteroid->diagonalAlign([1,5], [3,3]);
        $this->assertEquals([
            [4,2],
            [5,1],
            [6,0]
        ], $shadows);

        $shadows = $asteroid->diagonalAlign([3,3], [1,5]);
        $this->assertEquals([
            [0,6]
        ], $shadows);

        $shadows = $asteroid->diagonalAlign([0,0], [1,1]);
        $this->assertEquals([
            [2,2],
            [3,3],
            [4,4],
            [5,5],
            [6,6]
        ], $shadows);

        $shadows = $asteroid->diagonalAlign([6,6], [1,1]);
        $this->assertEquals([
            [0,0]
        ], $shadows);

        $shadows = $asteroid->diagonalAlign([6,6], [4,2]);
        $this->assertEquals([
            [3,0]
        ], $shadows);

    }

    public function testStepAlignA()
    {
        $input = <<<ASTEROID
#.........
...A......
...B..a...
.EDCG....a
..F.c.b...
.....c....
..efd.c.gb
.......c..
....f...c.
...e..d..c
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $this->assertEquals([
            [6,2],
            [9,3]
        ],
            $asteroid->diagonalAlign([0,0], [3,1])
        );
    }

    public function testStepAlignB()
    {
        $input = <<<ASTEROID
#.........
...A......
...B..a...
.EDCG....a
..F.c.b...
.....c....
..efd.c.gb
.......c..
....f...c.
...e..d..c
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $this->assertEquals([
            [6,4],
            [9,6]
        ],
            $asteroid->diagonalAlign([0,0], [3,2])
        );
    }

    public function testStepAlignC()
    {
        $input = <<<ASTEROID
#.........
...A......
...B..a...
.EDCG....a
..F.c.b...
.....c....
..efd.c.gb
.......c..
....f...c.
...e..d..c
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $this->assertEquals([
            [4,4],
            [5,5],
            [6,6],
            [7,7],
            [8,8],
            [9,9]
        ],
            $asteroid->diagonalAlign([0,0], [3,3])
        );
    }

    public function testStepAlignD()
    {
        $input = <<<ASTEROID
#.........
...A......
...B..a...
.EDCG....a
..F.c.b...
.....c....
..efd.c.gb
.......c..
....f...c.
...e..d..c
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $this->assertEquals([
            [4,6],
            [6,9]
        ],
            $asteroid->diagonalAlign([0,0], [2,3])
        );
    }

    public function testStepAlignE()
    {
        $input = <<<ASTEROID
#.........
...A......
...B..a...
.EDCG....a
..F.c.b...
.....c....
..efd.c.gb
.......c..
....f...c.
...e..d..c
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $this->assertEquals([
                [2,6],
                [3,9]
            ],
            $asteroid->diagonalAlign([0,0], [1,3])
        );
    }

    public function testStepAligF()
    {
        $input = <<<ASTEROID
#.........
...A......
...B..a...
.EDCG....a
..F.c.b...
.....c....
..efd.c.gb
.......c..
....f...c.
...e..d..c
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $this->assertEquals([
                [3,6],
                [4,8]
            ],
            $asteroid->diagonalAlign([0,0], [2,4])
        );
    }

    public function testStepAligG()
    {
        $input = <<<ASTEROID
#.........
...A......
...B..a...
.EDCG....a
..F.c.b...
.....c....
..efd.c.gb
.......c..
....f...c.
...e..d..c
ASTEROID;

        $asteroid = new \AOC\AsteroidField($input);
        $this->assertEquals([
                [8,6]
            ],
            $asteroid->diagonalAlign([0,0], [4,3])
        );
    }
}
