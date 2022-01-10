<?php
class Day24
{

    protected $input = [];

    protected $memory = [
        'w' => 0,
        'x' => 0,
        'y' => 0,
        'z' => 0
    ];

    protected $instructions = [];

    public function __construct($file)
    {
        $this->reset();

        $this->instructions = array_map(fn($l) => explode(' ', trim($l)), file($file));
    }

    public function dumpMemory()
    {
        echo 'w: ' . $this->memory['w'] . PHP_EOL;
        echo 'x: ' . $this->memory['x'] . PHP_EOL;
        echo 'y: ' . $this->memory['y'] . PHP_EOL;
        echo 'z: ' . $this->memory['z'] . PHP_EOL;
    }

    protected function reset()
    {
        $this->memory = [
            'w' => 0,
            'x' => 0,
            'y' => 0,
            'z' => 0
        ];
    }

    protected function read($address): int
    {
        if (array_key_exists($address, $this->memory)) {
            return intval($this->memory[$address]);
        }
        return intval($address);
    }

    protected function write(string $address, int $value)
    {
        if (array_key_exists($address, $this->memory)) {
            $this->memory[$address] = $value;
        } else {
            throw new \Exception('Unknown memory address');
        }
    }

    // inp a - Read an input value and write it to variable a.
    protected function inst_inp($a)
    {
        $this->write($a, array_pop($this->input));
    }

    // add a b - Add the value of a to the value of b, then store the result in variable a.
    protected function inst_add($a, $b)
    {
        $sum = $this->read($a) + $this->read($b);
        $this->write($a, $sum);
    }

    // mul a b - Multiply the value of a by the value of b, then store the result in variable a.
    protected function inst_mul($a, $b)
    {
        $prod = $this->read($a) * $this->read($b);
        $this->write($a, $prod);
    }

    // div a b - Divide the value of a by the value of b, truncate the result to an integer, then store the result in variable a. (Here, "truncate" means to round the value toward zero.)
    protected function inst_div($a, $b)
    {
        $res = floor($this->read($a) / $this->read($b));
        $this->write($a, $res);
    }

    // mod a b - Divide the value of a by the value of b, then store the remainder in variable a. (This is also called the modulo operation.)
    protected function inst_mod($a, $b)
    {
        $remainder = $this->read($a) % $this->read($b);
        $this->write($a, $remainder);
    }

    // eql a b - If the value of a and b are equal, then store the value 1 in variable a. Otherwise, store the value 0 in variable a.
    protected function inst_eql($a, $b)
    {
        $eql = $this->read($a) == $this->read($b);
        $this->write($a, $eql ? 1 : 0);
    }

    protected function run($input)
    {
        $this->input = $input;

        foreach ($this->instructions as $instruction) {
            switch ($instruction[0]) {
                case 'inp':
                    $this->inst_inp($instruction[1]);
                    break;
                case 'add':
                    $this->inst_add($instruction[1], $instruction[2]);
                    break;
                case 'mul':
                    $this->inst_mul($instruction[1], $instruction[2]);
                    break;
                case 'div':
                    $this->inst_div($instruction[1], $instruction[2]);
                    break;
                case 'mod':
                    $this->inst_mod($instruction[1], $instruction[2]);
                    break;
                case 'eql':
                    $this->inst_eql($instruction[1], $instruction[2]);
                    break;
            }
        }
    }

    public function test()
    {
        $this->run([9,3]);
        $this->dumpMemory();
        $this->run([3,8]);
        $this->dumpMemory();
    }

    public function part1()
    {


        echo 'Part 1: ' . $res . "\n\n";
    }

    public function part2()
    {
        $res = 'TBI';

        echo 'Part 2: ' . $res . "\n\n";
    }
}

$day24 = new Day24($argv[1]);
// $day24->test();
$day24->part1();
$day24->part2();
