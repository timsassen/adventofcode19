<?php

namespace AOC;

/**
 * Class AmplifierFeedbackArray
 * @package AOC
 */
class AmplifierFeedbackArray extends AmplifierArray
{
    /**
     * @return array
     */
    public function getRange()
    {
        return range(5,9);
    }

    /**
     * @param $permutation
     * @return bool|null
     */
    public function tryPermutation($permutation)
    {
        $thrust = null;
        $amplifierStack = [
            0 => new OptCode($this->instructions, [$permutation[0]]),
            1 => new OptCode($this->instructions, [$permutation[1]]),
            2 => new OptCode($this->instructions, [$permutation[2]]),
            3 => new OptCode($this->instructions, [$permutation[3]]),
            4 => new OptCode($this->instructions, [$permutation[4]])
        ];
        $feedback = new \InfiniteIterator(new \ArrayIterator($amplifierStack));

        $lastOpcodeOutput = null;

        /** @var OptCode $opcode */
        foreach ($feedback as $key => $opcode) {
            $input = ($lastOpcodeOutput == null) ? [0] : [$lastOpcodeOutput];
            $opcode->setInput($input);

            try {
                $lastOpcodeOutput = $opcode->run();
            } catch (HaltException $e) {
                break;
            }
        }

        return $lastOpcodeOutput;
    }
}