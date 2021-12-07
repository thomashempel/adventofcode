<?php
$input = file($argv[1]);

$positions = array_map(fn ($v) => intval(trim($v)), explode(',', $input[0]));
sort($positions);

function calcFuel($positions, $target) {
    $res = 0;
    foreach ($positions as $pos) {
        $res += abs($pos - $target);
    }
    return $res;
}

// BRUTE FORCE
// We simply cycle over all possible combinations and finde the
// lowest fuel consumption
// This works fine for the 1000 input numbers

$minFuel = PHP_INT_MAX;
$targetPos = 0;
$min = min($positions);
$max = max($positions);

echo $min . ' => ' . $max . "\n";

for ($i = $min; $i < $max; $i++) {
    $fuel = calcFuel($positions, $i);

    if ($fuel < $minFuel) {
        $minFuel = $fuel;
        $targetPos = $i;
    }
}

echo $targetPos . ' => ' . $minFuel . "\n";


// MEDIAN ?
// I'm not sure if this is actually the right approach,
// but this gives the right answer anyway. Ô_o

$num = count($positions);
$middleVal = floor(($num - 1) / 2);
$targetPos = 0;

if ($num % 2) {
    $targetPos = $positions[$middleVal];
} else {
    $lowMid = $positions[$middleVal];
    $highMid = $positions[$middleVal + 1];
    $targetPos = (($lowMid + $highMid) / 2);
}

echo $targetPos . ' => ' . calcFuel($positions, $targetPos);
