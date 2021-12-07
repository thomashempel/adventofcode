<?php
$input = file($argv[1]);

$positions = array_map(fn ($v) => intval(trim($v)), explode(',', $input[0]));
sort($positions);

$minFuel = PHP_INT_MAX;
$targetPos = 0;
$min = min($positions);
$max = max($positions);

echo $min . ' => ' . $max;

// BRUTE FORCE
// We simply cycle over all possible combinations and finde the
// lowest fuel consumption
// This works fine for the 1000 input numbers

for ($i = $min; $i < $max; $i++) {
    $fuel = 0;

    foreach ($positions as $pos) {
        $fuel += array_sum(range(0, abs($pos - $target)));
    }

    if ($fuel < $minFuel) {
        $minFuel = $fuel;
        $targetPos = $i;
    }
}

echo $targetPos . ' => ' . $minFuel;
