<?php
class Day13
{
    private $dots = [];
    private $folds = [];

    public function __construct($file)
    {
        $input = file($file);

        foreach ($input as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $parts = explode('fold along ', trim($line));
            if (count($parts) == 1) {
                list($x, $y) = explode(',', $parts[0]);
                $this->dots[$x.'x'.$y] = [intval($x), intval($y)];
            } else {
                $this->folds[] = $parts[1];
            }
        }
    }

    private function fold($fold)
    {
        $dots = [];

        list($axis, $edge) = explode('=', $fold);
        $edge = intval($edge);

        foreach ($this->dots as $dot) {
            $newDot = [];
            if ($axis == 'x' && $dot[0] > $edge) {
                $newDot = [$edge - ($dot[0] - $edge), $dot[1]];
                // var_dump([json_encode($dot) => json_encode($newDot)]);
            } elseif ($axis == 'y' && $dot[1] > $edge) {
                $newDot = [$dot[0], $edge - ($dot[1] - $edge)];
            } else {
                $newDot = $dot;
            }

            $dots[$newDot[0].'x'.$newDot[1]] = $newDot;
        }

        $this->dots = $dots;
    }

    public function part1()
    {
        $this->fold($this->folds[0]);
        $result = count($this->dots);
        echo 'Part 1: ' . $result . "\n\n";
    }

    public function part2()
    {
        foreach ($this->folds as $fold) {
            $this->fold($fold);
        }

        // print dots
        $maxX = 0;
        $maxY = 0;
        foreach ($this->dots as $dot) {
            if ($dot[0] > $maxX) { $maxX = $dot[0]; }
            if ($dot[1] > $maxY) { $maxY = $dot[1]; }
        }

        echo "Part 2: \n\n";

        for ($y = 0; $y <= $maxY; $y++) {
            for ($x = 0; $x <= $maxX; $x++) {
                echo array_key_exists($x.'x'.$y, $this->dots) ? '#' : ' ';
            }
            echo "\n";
        }
    }
}

$day11 = new Day13($argv[1]);
$day11->part1();
$day11->part2();
