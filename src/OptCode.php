<?php

namespace AOC;

/**
 * Class OptCode
 * @package AOC
 */
class OptCode
{
    /**
     * @var \ArrayIterator
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

    /**
     * OptCode constructor.
     * @param $file
     * @param $input
     * @param bool $verbose
     */
    public function __construct($file, $input, $verbose = false)
    {
        $code = explode(',', $file);
        $code = array_map(function ($string) {
            return (int)$string;
        }, $code);
        $this->code = new \ArrayIterator($code);
        $this->input = $input;
        $this->verbose = $verbose;
    }

    /**
     * @param mixed $input
     */
    public function setInput($input)
    {
        $this->input = $input;
    }

    /**
     * @return \ArrayIterator
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     *
     */
    function halt()
    {
        if ($this->verbose) {
            var_dump('halt');
        }
    }

    /**
     * @param $value
     * @return array
     */
    function parseInstruction($value)
    {
        $instruction = substr($value, strlen($value)-2, 2);
        $modes = substr($value, 0, strlen($value)-2);
        $modes = str_split($modes);
        $modes = array_reverse($modes);
        $returnModes = [0,0,0];
        foreach ($returnModes as $key => $returnMode) {
            if (isset($modes[$key])) {
                $returnModes[$key] = (int)$modes[$key];
            }
        }
        return [
            $instruction => $returnModes
        ];
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
    function compute($code, $instructionType, $parameter1, $parameter2 = null, $parameter3 = null, $modes = [0,0,0])
    {

        if ($instructionType == 1) {
            $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
            $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
            if ($this->verbose) {
                var_dump(sprintf("Add %s to %s and set to position %s", $parameter1, $parameter2, $parameter3));
            }
            $code[$parameter3] = $parameter1 + $parameter2;
        } elseif ($instructionType == 2) {
            $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
            $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
            if ($this->verbose) {
                var_dump(sprintf("Multiply %s with %s and set to position %s", $parameter1, $parameter2, $parameter3));
            }
            $code[$parameter3] = $parameter1 * $parameter2;
        } elseif ($instructionType == 3) {
            if ($this->verbose) {
                var_dump(sprintf("Set input %s to position %s", $this->input, $parameter1));
            }
            $code[$parameter1] = $this->input;
        } elseif ($instructionType == 4) {
            if ($this->verbose) {
                var_dump(sprintf("Output %s from position %s", ($modes[0] === 0) ? $code[$parameter1] : $parameter1, $parameter1));
            }
            return ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
        } elseif ($instructionType == 5) {
            $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
            $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
            if ($parameter1 !== 0) {
                if ($this->verbose) {
                    var_dump(sprintf("5: New pointer is %s", $parameter2));
                }
                return $parameter2;
            }
            return null;
        } elseif ($instructionType == 6) {
            $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
            $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
            if ($parameter1 === 0) {
                if ($this->verbose) {
                    var_dump(sprintf("6: New pointer is %s", $parameter2));
                }
                return $parameter2;
            }
            return null;
        } elseif ($instructionType == 7) {
            $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
            $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
            if ($this->verbose) {
                var_dump(sprintf("If %s is less than %s, set 1 to position %s", $parameter1, $parameter2, $parameter3));
            }
            $code[$parameter3] = $parameter1 < $parameter2 ? 1 : 0;
        } elseif ($instructionType == 8) {
            $parameter1 = ($modes[0] === 0) ? $code[$parameter1] : $parameter1;
            $parameter2 = ($modes[1] === 0) ? $code[$parameter2] : $parameter2;
            if ($this->verbose) {
                var_dump(sprintf("If %s is equal to %s, set 1 to position %s", $parameter1, $parameter2, $parameter3));
            }
            $code[$parameter3] = $parameter1 === $parameter2 ? 1 : 0;
        }


        return false;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $code = $this->getCode();
        foreach ($code as $i => $instructionType)
        {
            if ($instructionType == 99) {
                $this->halt();
                break;
            }

            if ($instructionType > 4 && strlen($instructionType) > 2)  {
                $instruction = $this->parseInstruction($instructionType);
                $instructionType = (int)key($instruction);
                $modes = current($instruction);
                $parameter1 = (int)$code[$i+1];
                $parameter2 = (in_array($instructionType, [1,2,5,6,7,8])) ? (int)$code[$i+2] : null;
                $parameter3 = (in_array($instructionType, [1,2,7,8])) ? (int)$code[$i+3] : null;

                try {
                    $currentOutput = $this->compute($code, $instructionType, $parameter1, $parameter2, $parameter3, $modes);
                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }
            } else {
                try {
                    $currentOutput = $this->compute($code, $instructionType, (int)$code[$i+1], (int)$code[$i+2], (int)$code[$i+3]);
                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }
            }

            if ($instructionType == 4 && $currentOutput != 0) {
                return $currentOutput;
            }

            if (in_array($instructionType, [3,4,99])) {
                $code->seek($i + 1);
            } elseif (in_array($instructionType, [5,6])) {
                $newPointer = $currentOutput;
                if (null !== $newPointer) {
                    $code->seek($newPointer-1);
                } else {
                    $code->seek($i + 2);
                }
             } elseif (in_array($instructionType, [1,2,7,8])) {
                $code->seek($i + 3);
            }
        }
    }
}