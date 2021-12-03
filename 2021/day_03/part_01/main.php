<?php
$input = file($argv[1]);

$line_size = strlen(trim($input[0]));
$counts = array_fill(0, $line_size, [0 => 0, 1 => 0]);

foreach ($input as $line) {
    for ($i = 0; $i < $line_size; $i++) {
        $val = intval($line[$i]);
        $counts[$i][$val]++;
    }
}

$gamma = '';
$epsilon = '';

for ($i = 0; $i < $line_size; $i++) {
    if ($counts[$i][0] > $counts[$i][1]) {
        $gamma .= '0';
        $epsilon .= '1';
    } else {
        $gamma .= '1';
        $epsilon .= '0';
    }
}

echo bindec($gamma) * bindec($epsilon);
