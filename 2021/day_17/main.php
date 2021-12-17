<?php
class Day17
{

    public function test()
    {

        $txmin = 20;
        $txmax = 30;
        $tymin = -5;
        $tymax = -10;

        $velocities = 0;
        $rest = $txmin + 1;
        $minXV = 0;

        do {
            $minXV++;
            $rest -= $minXV;
        } while ($rest > 0);

        $maxYV = abs($tymax) -1;

        for ($xsv = $minXV; $xsv <= $txmax; $xsv++) {
            for ($ysv = $tymax; $ysv <= $maxYV; $ysv++) {
                $x = 0;
                $y = 0;
                $xv = $xsv;
                $yv = $ysv;

                $overshoot = false;
                $hit = false;

                do {
                    $x += $xv;
                    $y += $yv;

                    if ($xv != 0) {
                        $xv = ($xv > 0) ? $xv - 1 : $xv + 1;
                    }
                    $yv -= 1;

                    if ($x >= $txmin && $x <= $txmax && $y <= $tymin && $y >= $tymax) {
                        $hit = true;
                        $velocities++;
                    }

                    if ($x > $txmax || $y < $tymax) {
                        $overshoot = true;
                    }
                } while ($overshoot == false && $hit == false);
            }
        }

        var_dump($velocities);
    }

    public function part1()
    {
        // $txmin = 269;
        // $txmax = 292;
        // $tymin = -44;
        $tymax = -68;

        $y = 0;
        $yv = abs($tymax) -1;

        do {
            $y += $yv;
            $yv--;
        } while ($yv > 0);

        echo 'Part 1: ' . $y . "\n\n";
    }

    public function part2()
    {
        $txmin = 269;
        $txmax = 292;
        $tymin = -44;
        $tymax = -68;

        $velocities = 0;
        $rest = $txmin + 1;
        $minXV = 0;

        do {
            $minXV++;
            $rest -= $minXV;
        } while ($rest > 0);

        $maxYV = abs($tymax) -1;

        for ($xsv = $minXV; $xsv <= $txmax; $xsv++) {
            for ($ysv = $tymax; $ysv <= $maxYV; $ysv++) {
                $x = 0;
                $y = 0;
                $xv = $xsv;
                $yv = $ysv;

                $overshoot = false;
                $hit = false;

                do {
                    $x += $xv;
                    $y += $yv;

                    if ($xv != 0) {
                        $xv = ($xv > 0) ? $xv - 1 : $xv + 1;
                    }
                    $yv -= 1;

                    if ($x >= $txmin && $x <= $txmax && $y <= $tymin && $y >= $tymax) {
                        $hit = true;
                        $velocities++;
                    }

                    if ($x > $txmax || $y < $tymax) {
                        $overshoot = true;
                    }
                } while ($overshoot == false && $hit == false);
            }
        }

        echo 'Part 2: ' . $velocities . "\n\n";
    }
}

$day17 = new Day17();
// $day17->test();
$day17->part1();
$day17->part2();
