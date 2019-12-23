<?php

namespace AOC;

class InteractiveOptCode extends OptCode
{
    protected $lastInstruction;

    protected $callableInput;

    public function __construct($code, array $input = [], bool $verbose = false, callable $callableInput)
    {
        parent::__construct($code, $input, $verbose);
        $this->callableInput = $callableInput;
    }

    /**
     * @param $code
     * @param $instructionType
     * @param $parameter1
     * @param null $parameter2
     * @param null $parameter3
     * @param array $modes
     * @param $callableInput
     * @return bool
     */
    function computeInteractive($code, $instructionType, $parameter1, $parameter2 = null, $parameter3 = null, $modes = [0, 0, 0])
    {
        if ($instructionType == 1) {
            if ($this->verbose) {
                var_dump(sprintf(
                    "Add %s to %s and set to position %s",
                    $this->read($parameter1, $modes[0]),
                    $this->read($parameter2, $modes[1]),
                    $parameter3
                ));
            }
            try {
                $this->write(
                    $parameter3,
                    $this->read($parameter1, $modes[0]) + $this->read($parameter2, $modes[1]),
                    $modes[2]
                );
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        } elseif ($instructionType == 2) {
            if ($this->verbose) {
                var_dump(sprintf(
                    "Multiply %s with %s and set to position %s",
                    $this->read($parameter1, $modes[0]),
                    $this->read($parameter2, $modes[1]),
                    $parameter3
                ));
            }

            try {
                $this->write(
                    $parameter3,
                    $this->read($parameter1, $modes[0]) * $this->read($parameter2, $modes[1]),
                    $modes[2]
                );
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        } elseif ($instructionType == 3) {
            try {
                $this->write($parameter1, ($this->callableInput)(), $modes[0]);
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        } elseif ($instructionType == 4) {
            if ($this->verbose) {
                var_dump(sprintf("Output %s from position %s", $this->read($parameter1, $modes[0])));
            }
            return $this->read($parameter1, $modes[0]);
        } elseif ($instructionType == 5) {
            $parameter1 = $this->read($parameter1, $modes[0]);
            $parameter2 = $this->read($parameter2, $modes[1]);

            if ($parameter1 !== 0) {
                if ($this->verbose) {
                    var_dump(sprintf("5: New pointer is %s", $parameter2));
                }
                return $parameter2;
            }
            return null;
        } elseif ($instructionType == 6) {
            $parameter1 = $this->read($parameter1, $modes[0]);
            $parameter2 = $this->read($parameter2, $modes[1]);

            if ($parameter1 === 0) {
                if ($this->verbose) {
                    var_dump(sprintf("6: New pointer is %s", $parameter2));
                }
                return $parameter2;
            }
            return null;
        } elseif ($instructionType == 7) {
            $parameter1 = $this->read($parameter1, $modes[0]);
            $parameter2 = $this->read($parameter2, $modes[1]);

            if ($this->verbose) {
                var_dump(sprintf("If %s is less than %s, set 1 to position %s", $parameter1, $parameter2, $parameter3));
            }
            try {
                $this->write($parameter3, ($parameter1 < $parameter2 ? 1 : 0), $modes[2]);
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        } elseif ($instructionType == 8) {
            $parameter1 = $this->read($parameter1, $modes[0]);
            $parameter2 = $this->read($parameter2, $modes[1]);

            if ($this->verbose) {
                var_dump(sprintf("If %s is equal to %s, set 1 to position %s", $parameter1, $parameter2, $parameter3));
            }
            try {
                $this->write($parameter3, ($parameter1 === $parameter2 ? 1 : 0), $modes[2]);
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        } elseif ($instructionType == 9) {
            $parameter1 = $this->read($parameter1, $modes[0]);

            $this->relativeBase += $parameter1;
        }


        return false;
    }


    /**
     * @return \Generator
     */
    public function run()
    {
        $currentOutput = null;

        for ($i = $this->index; $i < count($this->code); $i++) {
            $instructionType = $this->code[$i];

            if ($instructionType == 99) {
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
            $currentOutput = $this->compute($this->code, $instructionType, $parameter1, $parameter2, $parameter3, $modes);


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
                return $currentOutput;
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