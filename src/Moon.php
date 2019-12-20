<?php

namespace AOC;

class Moon
{
    protected $name;

    protected $x,$y,$z;

    protected $vx = 0;
    protected $vy = 0;
    protected $vz = 0;

    /**
     * Moon constructor.
     * @param $name
     * @param $x
     * @param $y
     * @param $z
     */
    public function __construct($name, $x, $y, $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->name = $name;
    }

    /**
     * @param $key
     * @param $value
     */
    public function update($key, $value)
    {
        $this->{$key} = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->{$key};
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getDimensionState($dimension)
    {
        $postion = $dimension;
        $velocity = "v" . $dimension;
        return sprintf(
            "%s=%s",
            $this->{$postion},
            $this->{$velocity}
        );
    }

    public function getState()
    {
        return sprintf(
            "%s-%s-%s=%s-%s-%s",
            $this->x,
            $this->y,
            $this->z,
            $this->vx,
            $this->vy,
            $this->vz
        );
    }

    /**
     *
     */
    public function print()
    {
        echo sprintf(
            "%s =<x= %s, y=%s, z=%s>, vel=<x= %s, y= %s, z= %s>",
            $this->getName(),
            $this->x,
            $this->y,
            $this->z,
            $this->vx,
            $this->vy,
            $this->vz
        );
    }

    /**
     * @return mixed
     */
    public function getKineticEnergy()
    {
        return abs($this->get('x')) + abs($this->get('y')) + abs($this->get('z'));
    }

    /**
     * @return mixed
     */
    public function getPotentialEnergy()
    {
        return abs($this->get('vx')) + abs($this->get('vy')) + abs($this->get('vz'));
    }

    /**
     * @return mixed
     */
    public function getTotalEnergy()
    {
        return $this->getKineticEnergy() * $this->getPotentialEnergy();
    }

}