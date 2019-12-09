<?php

namespace AOC;

/**
 * Class Amplifier
 * @package AOC
 */
class Amplifier
{
    /**
     * @var int|null
     */
    protected $inputs = null;

    /**
     * @var null
     */
    protected $instructions = null;

    /**
     * @var null
     */
    protected $output = null;
    protected $name;

    /**
     * Amplifier constructor.
     * @param $instructions
     * @param $phase
     * @param int $input
     */
    public function __construct($name, $instructions, $inputs = [])
    {
        $this->name = $name;
        $this->inputs = $inputs;
        $this->instructions = $instructions;
    }

    /**
     * @return bool
     */
    public function output()
    {
        $optCode = new OptCode($this->instructions, $this->inputs);
        return $optCode->run();
    }

}