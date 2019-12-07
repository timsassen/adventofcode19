<?php
include_once '../vendor/autoload.php';

class A
{
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

    public function execute()
    {
        $instructions = file_get_contents(__DIR__ . '/input.txt');
        $maxOutput = 0;
        $permutations = $this->permutations(range(0,4));

        foreach ($permutations as $key => $permutation) {
            $amplifierA = new \AOC\Amplifier('A', $instructions, $permutation[0]);
            $amplifierB = new \AOC\Amplifier('B', $instructions, $permutation[1], $amplifierA->output());
            $amplifierC = new \AOC\Amplifier('C', $instructions, $permutation[2], $amplifierB->output());
            $amplifierD = new \AOC\Amplifier('D', $instructions, $permutation[3], $amplifierC->output());
            $output = new \AOC\Amplifier('E', $instructions, $permutation[4], $amplifierD->output());
            $maxOutput = $output > $maxOutput ? $output : $maxOutput;
        }
        var_dump($maxOutput);
        exit;
    }
}

$a = new A();
$a->execute();