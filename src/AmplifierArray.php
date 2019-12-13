<?php

namespace AOC;

class AmplifierArray
{
    protected $instructions = [];

    public function __construct($instructions)
    {
        $this->instructions = $instructions;
    }

    function permutations(array $elements)
    {
        if (count($elements) <= 1) {
            yield $elements;
        } else {
            foreach ($this->permutations(array_slice($elements, 1)) as $permutation) {
                foreach (range(0, count($elements) - 1) as $i) {
                    yield array_merge(
                        array_slice($permutation, 0, $i),
                        [$elements[0]],
                        array_slice($permutation, $i)
                    );
                }
            }
        }
    }

    public function getRange()
    {
        return range(0,4);

    }

    public function getMaxOutput()
    {
        $maxOutput = 0;
        $permutations = $this->permutations($this->getRange());

        foreach ($permutations as $key => $permutation) {
            $output = $this->tryPermutation($permutation);
            $maxOutput = $output > $maxOutput ? $output : $maxOutput;
        }
        return $maxOutput;
    }

    public function tryPermutation($permutation)
    {
        $amplifierA = new \AOC\OptCode($this->instructions, [$permutation[0], 0]);
        $amplifierB = new \AOC\OptCode($this->instructions, [$permutation[1], $amplifierA->getOutput(0)]);
        $amplifierC = new \AOC\OptCode($this->instructions, [$permutation[2], $amplifierB->getOutput(0)]);
        $amplifierD = new \AOC\OptCode($this->instructions, [$permutation[3], $amplifierC->getOutput(0)]);
        $amplifierE = new \AOC\OptCode($this->instructions, [$permutation[4], $amplifierD->getOutput(0)]);
        return $amplifierE->getOutput(0);
    }
}