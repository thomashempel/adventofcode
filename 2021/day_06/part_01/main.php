<?php
$input = file($argv[1]);
$days = isset($argv[2]) ? intval($argv[2]) : 80;

$initialValues = array_map(fn ($v) => intval(trim($v)), explode(',', $input[0]));

$fish = [
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0,
    8 => 0
];

foreach ($initialValues as $v) {
    $fish[$v] += 1;
}

for ($day = 0; $day < $days; $day++) {
    $new = $fish[0];
    array_shift($fish);

    $fish[6] += $new;   // reset old ones
    $fish[] = $new;     // create new born

    echo 'Day ' . ($day + 1) . ' = ' . array_sum($fish) . "\n";
}
