<?php
class Day25
{

    protected $map = [];
    protected $w = 0;
    protected $h = 0;

    public function __construct($file)
    {
        $input = file($file);

        $this->map = array_map(fn ($l) => trim($l), $input);
        $this->w = strlen($this->map[0]);
        $this->h = count($this->map);
    }

    protected function debugMap()
    {
        foreach ($this->map as $line) {
            echo $line.PHP_EOL;
        }
        echo PHP_EOL.PHP_EOL;
    }

    protected function moveEast()
    {
        $newMap = $this->map;

        for ($l = 0; $l < $this->h; $l++) {
            for ($ci = 0; $ci < $this->w; $ci++) {
                $nc = ($ci == $this->w - 1) ? 0 : $ci + 1;

                if ($this->map[$l][$ci] == '>' && $this->map[$l][$nc] == '.') {
                    $newMap[$l][$nc] = '>';
                    $newMap[$l][$ci] = '.';
                }
            }
        }

        $this->map = $newMap;
    }

    protected function moveSouth()
    {
        $newMap = $this->map;

        for ($l = 0; $l < $this->h; $l++) {
            for ($ci = 0; $ci < $this->w; $ci++) {
                $nl = ($l == $this->h - 1) ? 0 : $l + 1;
                if ($this->map[$l][$ci] == 'v') {
                    if ($this->map[$nl][$ci] == '.') {
                        $newMap[$l][$ci] = '.';
                        $newMap[$nl][$ci] = 'v';
                    }
                }
            }
        }

        // last line
        for ($ci = 0; $ci < $this->w; $ci++) {
            if ($this->map[$this->h - 1][$ci] == 'v') {
                if ($this->map[0][$ci] == '.') {
                    $newMap[$this->h - 1][$ci] = '.';
                    $newMap[0][$ci] = 'v';
                }
            }
        }

        $this->map = $newMap;
    }

    public function test()
    {
        $count = 0;
        do {
            $lastMap = implode($this->map);
            $count++;
            $this->moveEast();
            $this->moveSouth();
            // $this->debugMap();
        } while (implode($this->map) != $lastMap);

        // for ($i = 0; $i < 7; $i++) {
        //     echo 'Step ' . ($i + 1) . PHP_EOL;
        //     $this->moveEast();
        //     $this->moveSouth();
        //     $this->debugMap();
        // }

        var_dump($count);
    }

    public function part1()
    {
        $res = 'TBI';

        echo 'Part 1: ' . $res . "\n\n";
    }

    public function part2()
    {
        $res = 'TBI';

        echo 'Part 2: ' . $res . "\n\n";
    }
}

$day25 = new Day25($argv[1]);
$day25->test();
$day25->part1();
$day25->part2();
