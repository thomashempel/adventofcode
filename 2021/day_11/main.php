<?php
class Day11
{
    private array $map = [];
    private $flashes = 0;

    public function __construct($file)
    {
        $input = file($file);
        foreach ($input as $line) {
            $this->map = array_merge(
                $this->map,
                array_map(fn ($v) => intval($v), str_split(trim($line)))
            );
        }
    }

    private function streamPos($i, $xdiff, $ydiff): int
    {
        $xpos = $i % 10;
        $ypos = ($i - $xpos) / 10;

        $newx = $xpos + $xdiff;
        $newy = $ypos + $ydiff;

        if ($newx < 0 || $newx > 9 || $newy < 0 || $newy > 99) {
            return -1;
        }

        return ($newy * 10) + $newx;
    }

    private function rise($i)
    {
        if ($i < 0 || $i > 99 || $this->map[$i] == -1) {
            return;
        }

        if ($this->map[$i] == 9) {
            $this->flashes += 1;
            $this->map[$i] = -1;

            $this->rise($this->streamPos($i, -1, -1));
            $this->rise($this->streamPos($i,  0, -1));
            $this->rise($this->streamPos($i,  1, -1));
            $this->rise($this->streamPos($i, -1,  0));
            $this->rise($this->streamPos($i,  1,  0));
            $this->rise($this->streamPos($i, -1,  1));
            $this->rise($this->streamPos($i,  0,  1));
            $this->rise($this->streamPos($i,  1,  1));
        } else {
            $this->map[$i] += 1;
        }

    }

    private function printMap()
    {
        $y = 0;
        foreach ($this->map as $i) {
            echo $i;
            $y++;
            if ($y == 10) {
                echo "\n";
                $y = 0;
            }
        }
        echo "\n";
    }


    private function step()
    {
        for ($i = 0; $i < 100; $i++) {
            $this->rise($i);
        }

        for ($i = 0; $i < 100; $i++) {
            if ($this->map[$i] == -1) {
                $this->map[$i] = 0;
            }
        }
    }

    public function part1()
    {
        for ($i = 0; $i < 100; $i++) {
            $this->step();
        }

        echo 'Part 1: ' . $this->flashes . "\n\n";
        $this->printMap();
    }

    private function allFlash(): bool
    {
        foreach ($this->map as $n) {
            if ($n != 0) {
                return false;
            }
        }
        return true;
    }

    public function part2()
    {
        $step = 0;
        do {
            $this->step();
            $step++;
        } while (!$this->allFlash());

        echo 'Part 2: ' . $step ."\n\n";
        $this->printMap();
    }
}

$day11 = new Day11($argv[1]);
$day11->part1();
$day11->part2();
