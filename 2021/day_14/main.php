<?php
class Day14
{
    private $pairs = [];
    private $rules = [];
    private $template = '';

    public function init(string $file)
    {
        $input = file($file);
        $this->pairs = [];

        foreach ($input as $line) {
            if (empty(trim($line))) {
                continue;
            }

            if (strpos($line, ' -> ') === false) {
                $this->template = trim($line);
                for ($i = 0; $i < strlen($this->template) - 1; $i++) {
                    $pair = substr($this->template, $i, 2);
                    $this->pairs = $this->add($this->pairs, $pair);
                }
            } else {
                list($from, $insert) = explode(' -> ', trim($line));
                $this->rules[$from] = $insert;
            }
        }
    }

    private function add(array $list, string $key, int $value = 1): array
    {
        if (!array_key_exists($key, $list)) {
            $list[$key] = 0;
        }
        $list[$key] += $value;
        return $list;
    }

    private function polymerize(int $iterations): int
    {
        // List of characters to count
        $counts = [];

        foreach (str_split($this->template) as $char) {
            $counts = $this->add($counts, $char);
        }

        for ($i = 0; $i < $iterations; $i++) {
            $new = $this->pairs;

            foreach ($this->rules as $pair => $insert) {
                if (!array_key_exists($pair, $this->pairs)) {
                    continue;
                }

                // How many pairs do exist?
                $count = $this->pairs[$pair];

                // Add the number of found to the character to be inserted
                $counts = $this->add($counts, $insert, $count);

                // Remove the number of pairs from the list of pairs
                $new = $this->add($new, $pair, $count * -1);

                // Create the new pairs from the old ones and the insert
                $new = $this->add($new, $pair[0] . $insert, $count);
                $new = $this->add($new, $insert . $pair[1], $count);
            }

            $this->pairs = $new;
        }

        // return the result
        return max($counts) - min($counts);
    }

    public function part1()
    {
        $res = $this->polymerize(10);
        echo 'Part 1: ' . $res . "\n\n";
    }

    public function part2()
    {
        $res = $this->polymerize(40);
        echo 'Part 2: ' . $res . "\n\n";
    }
}

$day14 = new Day14();
$day14->init($argv[1]);
$day14->part1();
$day14->init($argv[1]);
$day14->part2();
