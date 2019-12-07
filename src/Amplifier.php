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
    protected $input = null;

    /**
     * @var null
     */
    protected $phase = null;

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
    public function __construct($name, $instructions, $phase, $input = 0)
    {
        $this->phase = $phase;
        $this->input = $input;
        $this->instructions = $instructions;
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function output()
    {
        $optCode = new OptCode($this->instructions, $this->phase, $this->name === 'C');
        $optCode->run();
        var_dump($this->name . "check1");

        $optCode->setInput($this->input);
        if (is_null($this->output)) {
            var_dump($this->input);
            var_dump($this->name . "check2");
            $this->output = $optCode->run();
        }
        return $this->output;
    }

}