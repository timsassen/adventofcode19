<?php

namespace AOC;
use function foo\func;

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

    protected $observableAsteroidCount = [];

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
        $asteroids = $this->asteroids;
        foreach ($this->asteroids as $asteroid) {
            $observableAstroidCount = 0;
            //create ring
            $rings = $this->getRings($asteroid);

            //find asteroids in ring
            foreach ($rings as $ring) {
                $asteroidsInRing = array_filter($ring, function ($ringElement) use ($asteroids) {
                    return in_array($ringElement, $asteroids);
                });

                if (!empty($asteroidsInRing)) {
                    foreach ($asteroidsInRing as $asteroidInRing) {
                        //check if an asteroid is obscured
                        if ($this->isObscured($asteroidInRing)) {
                            //if it is, remove it from the list
                            $this->removeFromList($asteroidInRing);
                        } else {
                            //if not count it and calculate new obscure coords
                            $observableAstroidCount++;
                            $this->obscure($asteroid, $asteroidInRing);
                        }
                    }
                }
            }

            $this->observableAsteroidCount[join('x',$asteroid)] = $observableAstroidCount;
            $this->obscuredCoords = [];
        }
    }

    /**
     * @return array
     */
    public function getObservableAsteroidCount(): array
    {
        return $this->observableAsteroidCount;
    }

    /**
     * @param array $observableAsteroidCount
     */
    public function setObservableAsteroidCount(array $observableAsteroidCount): void
    {
        $this->observableAsteroidCount = $observableAsteroidCount;
    }

    public function removeFromList($asteroid)
    {
        unset($this->asteroids[array_search($asteroid, $this->asteroids)]);
    }

    public function verticalAlign($base, $asteroid)
    {
        $shadow = [];
        $deltaY = $base[1] - $asteroid[1];
        if ($deltaY < 1) {
            for ($i = $asteroid[1] + 1; $i <= $this->height - 1; $i++) {
                $shadow[] = [$asteroid[0], $i];
            }
        } else {
            for ($i = $asteroid[1] - 1; $i >= 0; $i--) {
                $shadow[] = [$asteroid[0], $i];
            }
        }
        return $shadow;
    }

    public function horizontalAlign($base, $asteroid)
    {
        $shadow = [];
        $deltaX = $base[0] - $asteroid[0];
        if ($deltaX < 1) {
            for ($i = $asteroid[0] + 1; $i <= $this->width - 1; $i++) {
                $shadow[] = [$i, $asteroid[1]];
            }
        } else {
            for ($i = $asteroid[0] - 1; $i >= 0; $i--) {
                $shadow[] = [$i, $asteroid[1]];
            }
        }
        return $shadow;
    }

    const RIGHT = "R";
    const LEFT = "L";
    const UP = "U";
    const DOWN = "D";

    public function isOutOfBounds($coord)
    {
        if ($coord[0] < 0 || $coord[1] < 0) {
            return true;
        }
        if ($coord[0] > ($this->width - 1)) {
            return true;
        }
        if ($coord[1] > ($this->height - 1)) {
            return true;
        }
        return false;
    }

    function gcd($a,$b) {
        return ($a % $b) ? $this->gcd($b,$a % $b) : $b;
    }

    public function diagonalAlign($base, $asteroid)
    {
        $xDir = ($base[0] < $asteroid[0]) ? self::RIGHT : self::LEFT;
        $yDir = ($base[1] < $asteroid[1]) ? self::DOWN : self::UP;
        $deltaX = abs($base[0] - $asteroid[0]);
        $deltaY = abs($base[1] - $asteroid[1]);
        $commonDenominator = $this->gcd($deltaX, $deltaY);

        $deltaX = $deltaX / $commonDenominator;
        $deltaY = $deltaY / $commonDenominator;

        $outOfBounds = false;
        $lastShadow = $asteroid;
        $shadows = [];
        while (!$outOfBounds) {
            $newX = ($xDir == self::RIGHT) ? $lastShadow[0] + $deltaX : $lastShadow[0] - $deltaX;
            $newY = ($yDir == self::DOWN) ? $lastShadow[1] + $deltaY : $lastShadow[1] - $deltaY;

            $newShadow = [$newX, $newY];
            $outOfBounds = $this->isOutOfBounds($newShadow);
            if (!$outOfBounds) {
                $shadows[] = $newShadow;
                $lastShadow = $newShadow;
            }
        }
        return $shadows;
    }

    public function obscure($base, $asteroid)
    {
        if ($base[0] == $asteroid[0]) {
            $shadows = $this->verticalAlign($base, $asteroid);
        } elseif ($base[1] == $asteroid[1]) {
            $shadows = $this->horizontalAlign($base, $asteroid);
        } else {
            $shadows = $this->diagonalAlign($base, $asteroid);
        }

        if (!empty($shadows)) {
            $this->obscuredCoords = array_merge($this->obscuredCoords, $shadows);
        }
    }

    public function isObscured($asteroid)
    {
        return false !== array_search($asteroid, $this->obscuredCoords);
    }

    public function getRings($base)
    {
        $rings = [];
        $max = max(
            $this->height - $base[1] - 1,
            $base[1],
            $this->width - $base[0] - 1,
            $base[0]
        );

        for ($i = 1; $i <= $max; $i++) {
            $ring = $this->createRing($i, $base);
            if (empty($ring)) {
                break;
            }
            $rings[] = $ring;
        }
        return $rings;
    }

    public function createRing($distance, $base)
    {
        $ring = [[$base[0], $base[1] - $distance]];

        //right 1 distance
        $minRight = end($ring)[0] + 1;
        $maxRight = end($ring)[0] + $distance;
        for ($i = $minRight; $i <= $maxRight; $i++) {
            $arr = [$i, end($ring)[1]];
            $ring[] = $arr;
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

        //up 2 distances
        $minUp = end($ring)[1] - 1;
        $maxUp = end($ring)[1] - ($distance * 2);
        for ($i = $minUp; $i >= $maxUp; $i--) {
            $ring[] = [$base[0] - $distance, $i];
        }

        //right 1 distance
        $minRight = end($ring)[0] + 1;
        $maxRight = end($ring)[0] + $distance - 1;
        for ($i = $minRight; $i <= $maxRight; $i++) {
            $ring[] = [$i, end($ring)[1]];
        }

        //filter out negatives
        foreach ($ring as $key => $item) {
            if ($item[0] < 0
                || $item[1] < 0
            ) {
                unset($ring[$key]);
            }
        }
        return array_values($ring);
    }

    public function getMaxObservableAsteroidCount()
    {
        return max($this->observableAsteroidCount);
    }

    public function paint($ring)
    {
        for ($i = 0; $i <= $this->height - 1; $i++) {
            for ($j = 0; $j <= $this->width - 1; $j++) {
                if (in_array([$j, $i], $ring)) {
                    print '#';
                } else {
                    print '.';
                }
            }
            echo PHP_EOL;
        }
        echo "_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-";
        echo PHP_EOL;
    }
}