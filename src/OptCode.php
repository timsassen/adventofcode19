<?php

namespace AOC;

/**
 * Class OptCode
 * @package AOC
 */
class OptCode
{
    /**
     * @var array
     */
    protected $code;
    /**
     * @var
     */
    protected $input;
    /**
     * @var bool
     */
    protected $verbose;

    protected $index = 0;

    protected $relativeBase = 0;

    protected $output = [];

    /**
     * OptCode constructor.
     * @param $code
     * @param $input
     * @param bool $verbose
     */
    public function __construct($code, $input = [], $verbose = false)
    {
        $this->code = $code;
        $this->input = $input;
        $this->verbose = $verbose;
    }

    /**
     * @param mixed $input
     */
    public function setInput($input)
    {
        $this->input = array_merge($this->input, $input);
//        $this->input = $input;
    }

    /**
     * @return \ArrayIterator
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $index
     * @return mixed
     */
    public function readAt($index)
    {
        return $this->code[$index];
    }

    /**
     * @param $value
     * @return array
     */
    function parseInstruction($value)
    {
        $instruction = substr($value, strlen($value) - 2, 2);
        $modes = substr($value, 0, strlen($value) - 2);
        $modes = str_split($modes);
        $modes = array_reverse($modes);
        $returnModes = [0, 0, 0];
        foreach ($returnModes as $key => $returnMode) {
            if (isset($modes[$key])) {
                $returnModes[$key] = (int)$modes[$key];
            }
        }
        return [
            $instruction => $returnModes
        ];
    }

    public function write($parameter, $value, $mode)
    {
        switch ($mode) {
            case 0: $address = $parameter; break;
            case 2: $address = $this->relativeBase += $parameter; break;
        }

        if (!isset($this->code[$address])) {
            $this->code = array_pad($this->code, $address + 1, 0);
        }

        $this->code[$address] = $value;
    }

    public function read($parameter, $mode)
    {
        if ($mode == 1) {
            return $parameter;
        }
        switch ($mode) {
            case 0: $address = $parameter; break;
            case 2: $address = $this->relativeBase += $parameter; break;
        }


        if (!isset($this->code[$address])) {
            if ($this->verbose) {
//                var_dump($this->code);
            }
            $this->code = array_pad($this->code, $address + 1, 0);
            if ($this->verbose) {
//                var_dump($address);
//                var_dump($this->code);
//                var_dump(count($this->code));
//                exit;
            }
        }

        return $this->code[$address];
    }

    /**
     * @param $code
     * @param $instructionType
     * @param $parameter1
     * @param null $parameter2
     * @param null $parameter3
     * @param array $modes
     * @return bool
     */
    function compute($code, $instructionType, $parameter1, $parameter2 = null, $parameter3 = null, $modes = [0, 0, 0])
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

            $this->write(
                $parameter3,
                $this->read($parameter1, $modes[0]) + $this->read($parameter2, $modes[1]),
                $modes[2]
            );
        } elseif ($instructionType == 2) {
            if ($this->verbose) {
                var_dump(sprintf(
                    "Multiply %s with %s and set to position %s",
                    $this->read($parameter1, $modes[0]),
                    $this->read($parameter2, $modes[1]),
                    $parameter3
                ));
            }

            $this->write(
                $parameter3,
                $this->read($parameter1, $modes[0]) * $this->read($parameter2, $modes[1]),
                $modes[2]
            );
        } elseif ($instructionType == 3) {
            $insertValue = array_shift($this->input);
            if ($this->verbose) {
                var_dump(sprintf("Set input %s to position %s", $insertValue, $parameter1));
            }
            $this->code[$parameter1] = $insertValue;
        } elseif ($instructionType == 4) {
            if ($this->verbose) {
                var_dump(sprintf("Output %s from position %s", ($modes[0] === 0) ? $this->code[$parameter1] : $parameter1, $parameter1));
            }
            return ($modes[0] === 0) ? $this->code[$parameter1] : $parameter1;
        } elseif ($instructionType == 5) {
            if ($modes[0] === 0) {
                $parameter1 = $this->code[$parameter1];
            } elseif ($modes[0] === 2) {
                $parameter1 = $this->code[$this->relativeBase += $parameter1];
            }
            if ($modes[1] === 0) {
                $parameter2 = $this->code[$parameter2];
            } elseif ($modes[1] === 2) {
                $parameter2 = $this->code[$this->relativeBase += $parameter2];
            }
            if ($parameter1 !== 0) {
                if ($this->verbose) {
                    var_dump(sprintf("5: New pointer is %s", $parameter2));
                }
                return $parameter2;
            }
            return null;
        } elseif ($instructionType == 6) {
            if ($modes[0] === 0) {
                $parameter1 = $this->code[$parameter1];
            } elseif ($modes[0] === 2) {
                $parameter1 = $this->code[$this->relativeBase += $parameter1];
            }
            if ($modes[1] === 0) {
                $parameter2 = $this->code[$parameter2];
            } elseif ($modes[1] === 2) {
                $parameter2 = $this->code[$this->relativeBase += $parameter2];
            }
            if ($parameter1 === 0) {
                if ($this->verbose) {
                    var_dump(sprintf("6: New pointer is %s", $parameter2));
                }
                return $parameter2;
            }
            return null;
        } elseif ($instructionType == 7) {
            if ($modes[0] === 0) {
                $parameter1 = $this->code[$parameter1];
            } elseif ($modes[0] === 2) {
                $parameter1 = $this->code[$this->relativeBase += $parameter1];
            }
            if ($modes[1] === 0) {
                $parameter2 = $this->code[$parameter2];
            } elseif ($modes[1] === 2) {
                $parameter2 = $this->code[$this->relativeBase += $parameter2];
            }
            if ($this->verbose) {
                var_dump(sprintf("If %s is less than %s, set 1 to position %s", $parameter1, $parameter2, $parameter3));
            }
            $this->code[$parameter3] = $parameter1 < $parameter2 ? 1 : 0;
        } elseif ($instructionType == 8) {
            if ($modes[0] === 0) {
                $parameter1 = $this->code[$parameter1];
            } elseif ($modes[0] === 2) {
                $parameter1 = $this->code[$this->relativeBase += $parameter1];
            }
            if ($modes[1] === 0) {
                $parameter2 = $this->code[$parameter2];
            } elseif ($modes[1] === 2) {
                $parameter2 = $this->code[$this->relativeBase += $parameter2];
            }
            if ($this->verbose) {
                var_dump(sprintf("If %s is equal to %s, set 1 to position %s", $parameter1, $parameter2, $parameter3));
            }
            $this->code[$parameter3] = $parameter1 === $parameter2 ? 1 : 0;
        } elseif ($instructionType == 9) {
            if ($modes[0] === 0) {
                $parameter1 = $this->code[$parameter1];
            } elseif ($modes[0] === 2) {
                $parameter1 = $this->code[$this->relativeBase += $parameter1];
            }
            $this->relativeBase += $parameter1;
        }


        return false;
    }

    /**
     * @return bool|null|array
     * @throws HaltException
     */
    public function run()
    {
        $currentOutput = null;

        for ($i = $this->index; $i < count($this->code); $i++) {
            $instructionType = $this->code[$i];

            if ($instructionType == 99) {
                $haltException = new HaltException($currentOutput);
                $haltException->setLastOutput($currentOutput);
                throw $haltException;
            }

            if ($instructionType > 4 && strlen($instructionType) > 2) {
                $instruction = $this->parseInstruction($instructionType);
                $instructionType = (int)key($instruction);
                $modes = current($instruction);
                $parameter1 = (int)$this->code[$i + 1];
                $parameter2 = (in_array($instructionType, [1, 2, 5, 6, 7, 8, 9])) ? (int)$this->code[$i + 2] : null;
                $parameter3 = (in_array($instructionType, [1, 2, 7, 8])) ? (int)$this->code[$i + 3] : null;

                try {
                    $currentOutput = $this->compute($this->code, $instructionType, $parameter1, $parameter2, $parameter3, $modes);
                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }
            } else {
                try {
                    $currentOutput = $this->compute($this->code, $instructionType, (int)$this->code[$i + 1], (int)$this->code[$i + 2], (int)$this->code[$i + 3]);
                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }
            }


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

            if ($instructionType == 4 && $currentOutput != 0) {
                $this->index = $i;
                return $currentOutput;
            }
        }
    }
}