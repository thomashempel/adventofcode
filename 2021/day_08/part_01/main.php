<?php
$input = file($argv[1]);

// $counts = array_fill(0, 9, 0);
$count = 0;

foreach ($input as $line) {
    list($input, $output) = explode('|', $line);
    $outputSegments = array_map(fn ($v) => trim($v), explode(' ', $output));

    foreach ($outputSegments as $s) {
        if (in_array(strlen($s), [2, 3, 4, 7])) {
            $count++;
        }
    }
}

echo $count;
