<?php

namespace AOC;

use Throwable;

class HaltException extends \Exception
{
    protected $lastOutput;


    /**
     * @return mixed
     */
    public function getLastOutput()
    {
        return $this->lastOutput;
    }

    /**
     * @param mixed $lastOutput
     */
    public function setLastOutput($lastOutput)
    {
        $this->lastOutput = $lastOutput;
    }

}