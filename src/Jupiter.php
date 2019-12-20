<?php

namespace AOC;

/**
 * Class Jupiter
 * @package AOC
 */
class Jupiter
{
    /**
     * @var Moon[]
     */
    protected $moons = [];

    /**
     * @var array
     */
    protected $map = [];

    /**
     * Jupiter constructor.
     * @param $moons
     */
    public function __construct($moons)
    {
        $this->moons = $moons;
        foreach ($this->moons as $key => $moon) {
            $this->map[$moon->getName()] = $key;
        }
    }

    /**
     * @param Moon $moon
     * @return mixed
     */
    public function getKey(Moon $moon)
    {
        return $this->map[$moon->getName()];
    }

    /**
     * @param Moon $moon
     */
    public function updateMoon(Moon $moon)
    {
        $this->moons[$this->getKey($moon)] = $moon;
    }

    public function getMoon($index)
    {
        return $this->moons[$index];
    }

    public function optimizedGravityPlusVelocity($dimension)
    {
        $postion = $dimension;
        $velocity = "v".$dimension;

        foreach ([[0,1],[0,2],[0,3],[1,2],[1,3],[2,3]] as $pair) {
            if ($this->moons[$pair[0]]->get($postion) < $this->moons[$pair[1]]->get($postion)) {
                $this->moons[$pair[0]]->update($velocity, $this->moons[$pair[0]]->get($velocity) + 1);
                $this->moons[$pair[1]]->update($velocity, $this->moons[$pair[1]]->get($velocity) - 1);
            } elseif ($this->moons[$pair[0]]->get($postion) > $this->moons[$pair[1]]->get($postion)) {
                $this->moons[$pair[0]]->update($velocity, $this->moons[$pair[0]]->get($velocity) - 1);
                $this->moons[$pair[1]]->update($velocity, $this->moons[$pair[1]]->get($velocity) + 1);
            }
        }
        for ($i = 0; $i <= 3; $i++) {
            $this->moons[$i]->update($postion, $this->moons[$i]->get($postion) + $this->moons[$i]->get($velocity));
        }
    }

    public function applyGravity()
    {
        foreach ($this->pairs() as $pair) {
            /** @var Moon $pairA */
            $pairA = $this->getMoon($pair[0]);
            /** @var Moon $pairB */
            $pairB = $this->getMoon($pair[1]);

            if ($pairA->get('x') < $pairB->get('x')) {
                $pairA->update('vx', $pairA->get('vx') + 1);
                $pairB->update('vx', $pairB->get('vx') - 1);
            } elseif ($pairA->get('x') > $pairB->get('x')) {
                $pairA->update('vx', $pairA->get('vx') - 1);
                $pairB->update('vx', $pairB->get('vx') + 1);
            }

            if ($pairA->get('y') < $pairB->get('y')) {
                $pairA->update('vy', $pairA->get('vy') + 1);
                $pairB->update('vy', $pairB->get('vy') - 1);
            } elseif ($pairA->get('y') > $pairB->get('y')) {
                $pairA->update('vy', $pairA->get('vy') - 1);
                $pairB->update('vy', $pairB->get('vy') + 1);
            }

            if ($pairA->get('z') < $pairB->get('z')) {
                $pairA->update('vz', $pairA->get('vz') + 1);
                $pairB->update('vz', $pairB->get('vz') - 1);
            } elseif ($pairA->get('z') > $pairB->get('z')) {
                $pairA->update('vz', $pairA->get('vz') - 1);
                $pairB->update('vz', $pairB->get('vz') + 1);
            }

            $this->updateMoon($pairA);
            $this->updateMoon($pairB);
        }
    }

    public function getDimensionState($dimension)
    {
        return $this->moons[0]->getDimensionState($dimension)
            . '/' . $this->moons[1]->getDimensionState($dimension)
            . '/' . $this->moons[2]->getDimensionState($dimension)
            . '/' . $this->moons[3]->getDimensionState($dimension);
    }

    public function getState()
    {
        return $this->moons[0]->getState() . '/' . $this->moons[1]->getState() . '/' . $this->moons[2]->getState() . '/' . $this->moons[3]->getState();
    }

    public function applyVelocity()
    {
        foreach ($this->moons as $key => $moon) {
            $moon->update('x', $moon->get('x') + $moon->get('vx'));
            $moon->update('y', $moon->get('y') + $moon->get('vy'));
            $moon->update('z', $moon->get('z') + $moon->get('vz'));
            $this->updateMoon($moon);
        }
    }

    public function getTotalEnergy()
    {
        $totalEnergy = 0;
        foreach ($this->moons as $moon) {
            $totalEnergy += $moon->getTotalEnergy();
        }

        return $totalEnergy;
    }

    /**
     * @return array
     */
    public function pairs()
    {
        $pairs = [];
        for($j = 0; $j < count($this->moons); $j++) {
            for($x = 0; $x < count($this->moons); $x++) {
                if ($x >= $j) {
                    continue;
                }
                if(!isset($pairs[$j][$x])) {
                    $pairs[$j . '-' . $x] = [$j, $x];
                }
            }
        }

        return $pairs;
    }

    public function print()
    {
        foreach ($this->moons as $moon) {
            echo $moon->print() . PHP_EOL;
        }
    }


}