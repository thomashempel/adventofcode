<?php
require './astar/src/ScoreHeap.php';
require './astar/src/HeuristicInterface.php';
require './astar/src/Heuristic/Manhattan.php';
require './astar/src/NodeCollectionInterface.php';
require './astar/src/Grid.php';
require './astar/src/Node.php';
require './astar/src/Astar.php';


class Day15
{
    protected $w = 0;
    protected $h = 0;
    protected $map = [];

    public function __construct(string $file)
    {
        $this->reset($file);
    }

    public function reset(string $file)
    {
        $input = file($file);

        $this->map = array_map(fn ($v) => str_split(trim($v)), $input);

        $this->w = count($this->map[0]);
        $this->h = count($this->map);
    }

    protected function astar()
    {
        $grid = new BlackScorp\Astar\Grid($this->map);
        $start = $grid->getPoint(0, 0);
        $end = $grid->getPoint(count($this->map[0]) - 1, count($this->map) - 1);
        $astar = new BlackScorp\Astar\Astar($grid);
        $nodes = $astar->search($start, $end);

        return array_pop($nodes)->getTotalScore();
    }

    public function part1()
    {
        echo 'Part 1: ' . $this->astar() . "\n\n";
    }

    protected function printMap($map)
    {
        for ($y = 0; $y < count($map); $y++) {
            for ($x = 0; $x < count($map[$y]); $x++) {
                echo $map[$y][$x];
            }
            echo "\n";
        }
    }

    public function part2()
    {
        $largeMap = array_fill(0, $this->h * 5, array_fill(0, $this->w * 5, 0));


        for ($y = 0; $y < $this->h; $y++) {
            for ($x = 0; $x < $this->w; $x++) {
                $oValue = $this->map[$y][$x];
                $largeMap[$y][$x] = $oValue;

                for ($i = 1; $i <= 4; $i++) {
                    $nValue = $largeMap[$y][$x + (($i - 1) * $this->w)] + 1;
                    if ($nValue > 9) {
                        $nValue = 1;
                    }
                    $largeMap[$y][$x + ($i * $this->w)] = $nValue;
                }
            }
        }

        for ($x = 0; $x < count($largeMap[0]); $x++) {
            for ($y = 0; $y < $this->h; $y++) {
                $oValue = $largeMap[$y][$x];

                for ($i = 1; $i <= 4; $i++) {
                    $nValue = $largeMap[$y + (($i - 1) * $this->h)][$x] + 1;
                    if ($nValue > 9) {
                        $nValue = 1;
                    }
                    $largeMap[$y + ($i * $this->h)][$x] = $nValue;
                }
            }
        }

        $this->map = $largeMap;

        echo 'Part 2: ' . $this->astar() . "\n\n";
    }
}

$day14 = new Day15($argv[1]);
// $day14->part1();
$day14->part2();
