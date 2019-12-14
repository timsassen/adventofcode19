<?php

namespace AOC;

/**
 * Class Astroid
 * @package AOC
 */
class AsteroidField
{

    /**
     * @var []
     */
    protected $asteroids;

    protected $asteroidCount = [];

    protected $height;

    protected $width;

    protected $obscuredCoords = [];

    /**
     * Astroid constructor.
     * @param $field
     */
    public function __construct($field)
    {
        $lineCounter = 0;
        foreach (explode("\n", $field) as $line) {
            $columns = str_split($line);
            $this->width = count($columns);
            foreach ($columns as $x => $column) {
                if ($column == '#') {
                    $this->asteroids[] = [$x, $lineCounter];
                }
            }
            $lineCounter++;
        }
        $this->height = $lineCounter;
    }

    /**
     * @return array
     */
    public function getAsteroidCount(): array
    {
        return $this->asteroidCount;
    }

    /**
     * @param array $asteroidCount
     */
    public function setAsteroidCount(array $asteroidCount): void
    {
        $this->asteroidCount = $asteroidCount;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return array
     */
    public function getObscuredCoords(): array
    {
        return $this->obscuredCoords;
    }

    /**
     * @param array $obscuredCoords
     */
    public function setObscuredCoords(array $obscuredCoords): void
    {
        $this->obscuredCoords = $obscuredCoords;
    }


    /**
     * @return mixed
     */
    public function getAsteroids()
    {
        return $this->asteroids;
    }

    public function check()
    {
        foreach ($this->asteroids as $asteroid) {
            //create ring
            //find asteroids in ring
            //check if an asteroid is obscured
                //if not count it and calculate new obscure coords
                //if it is, remove it from the list

        }
    }

    public function getRings($base)
    {
        $rings = [];
        $corners = [
            [0,0],
            [0, $this->width],
            [$this->height,0],
            [$this->height, $this->width]
        ];
        $max = max($this->height - 1, $this->width - 1);
        for ($i = 0; $i <= $max; $i++) {
            $rings[] = $this->createRing($i, $base);
        }
    }

    public function createRing($distance, $base)
    {
        $ring = [[$base[0] - $distance, $base[1]]];

        //up 1 distance
        $minUp = end($ring)[1] - 1;
        $maxUp = end($ring)[1] - $distance;
        for ($i = $minUp; $i >= $maxUp; $i--) {
            $arr = [end($ring)[0], $i];
            $ring[] = $arr;
        }

        //right 2 distance
        $maxRight = end($ring)[0] + ($distance * 2);
        $minRight = end($ring)[0] + 1;
        for ($i = $minRight; $i <= $maxRight; $i++) {
            $ring[] = [$i, end($ring)[1]];
        }

        //down 2 distance
        $maxDown = end($ring)[1] + ($distance * 2);
        $minDown = end($ring)[1] + 1;
        for ($i = $minDown; $i <= $maxDown; $i++) {
            $ring[] = [end($ring)[0], $i];
        }

        //left 2 distance
        $minLeft = end($ring)[0] - 1;
        $maxLeft = end($ring)[0] - ($distance * 2);
        for ($i = $minLeft; $i >= $maxLeft; $i--) {
            $ring[] = [$i, end($ring)[1]];
        }

        //up 1 distance
        $minUp = end($ring)[1] - 1;
        $maxUp = end($ring)[1] - $distance + 1;
        for ($i = $minUp; $i >= $maxUp; $i--) {
            $ring[] = [$base[0] - $distance, $i];
        }

        //filter out negatives
        foreach ($ring as $key => $item) {
            if ($item[0] < 0 || $item[1] < 0) {
                unset($ring[$key]);
            }
        }
        return array_values($ring);
    }


}