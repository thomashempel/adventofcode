<?php
$input = file($argv[1]);
$lines = count($input);
$line = 0;
$trees = [];
$steps = [
    ['x' => 1, 'y' => 1],
    ['x' => 3, 'y' => 1],
    ['x' => 5, 'y' => 1],
    ['x' => 7, 'y' => 1],
    ['x' => 1, 'y' => 2]
];

foreach ($steps as $si => $step) {
    $trees[$si] = 0;
    $x = 0;
    echo "\n-- SET $si x: " . $step['x'] . " y: " . $step['y'] . " --\n";
    for ($lineIndex = 0; $lineIndex < $lines; $lineIndex += $step['y']) {
        $line = trim($input[$lineIndex]);
        $inline_offset = $x % strlen($line);
        if ($line[$inline_offset] == '#') {
            $trees[$si]++;
            $line[$inline_offset] = 'X';
        } else {
            $line[$inline_offset] = 'O';
        }
        $x += $step['x'];
        echo $line . "\n";
    }
}

echo array_product($trees);
