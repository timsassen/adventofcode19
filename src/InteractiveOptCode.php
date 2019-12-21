<?php

namespace AOC;

class InteractiveOptCode extends OptCode
{
    protected $lastInstruction;

    public function run()
    {
        $currentOutput = null;

        for ($i = $this->index; $i < count($this->code); $i++) {
            $instructionType = $this->code[$i];

            if ($instructionType == 99) {
                $this->lastInstruction = $instructionType;
                $this->index = $i;
                break;
            }

            if ($instructionType > 4 && strlen($instructionType) > 2) {
                $instruction = $this->parseInstruction($instructionType);
                $instructionType = (int)key($instruction);
                $modes = current($instruction);
                $parameter1 = (int)$this->code[$i + 1];
                $parameter2 = (in_array($instructionType, [1, 2, 5, 6, 7, 8, 9])) ? (int)$this->code[$i + 2] : null;
                $parameter3 = (in_array($instructionType, [1, 2, 7, 8])) ? (int)$this->code[$i + 3] : null;
            } else {
                $parameter1 = (int)$this->code[$i + 1];
                $parameter2 = (int)$this->code[$i + 2];
                $parameter3 = (int)$this->code[$i + 3];
                $modes = [0, 0, 0];
            }
            if ($instructionType == 3 && empty($this->input)) {
                if ($this->verbose) {
                    var_dump("break for input");
                }
                $this->lastInstruction = $instructionType;
                $this->index = 0;
                break;
            }
            $currentOutput = $this->compute($this->code, $instructionType, $parameter1, $parameter2, $parameter3, $modes);
            $this->lastInstruction = $instructionType;

            if (in_array($instructionType, [3, 4, 99, 9])) {
                $i++;
            } elseif (in_array($instructionType, [5, 6])) {
                $newPointer = $currentOutput;
                if (null !== $newPointer) {
                    $i = $newPointer - 1;
                } else {
                    $i = $i + 2;
                }
            } elseif (in_array($instructionType, [1, 2, 7, 8])) {
                $i = $i + 3;
            }
            $this->index = $i;

            if ($instructionType == 4) {
                yield $currentOutput;
            }
        }
    }

    /**
     * @return int
     */
    public function getLastInstruction()
    {
        return $this->lastInstruction;
    }
}