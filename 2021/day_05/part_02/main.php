<?php
require_once '../Point.php';
require_once '../Line.php';

$input = file($argv[1]);
$points = [];

foreach ($input as $line) {
    list($p1, $p2) = explode('-> ', $line);
    $l = new Line($p1, $p2);

    if (!$l->isStraight(true)) {
        continue;
    }

    foreach ($l->getPoints() as $p) {
        if (!array_key_exists($p, $points)) {
            $points[$p] = 0;
        }

        $points[$p] += 1;
    }
}

$crosssections = 0;
foreach ($points as $p) {
    if ($p >= 2) {
        $crosssections++;
    }
}

echo $crosssections;
