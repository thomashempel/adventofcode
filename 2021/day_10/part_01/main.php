<?php
$input = file($argv[1]);
$values = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137
];

function checkLine($line) {
    $open = ['(', '[', '{', '<'];
    $close = [')', ']', '}', '>'];

    $stack = [];

    for ($i = 0; $i < strlen($line); $i++) {
        if (in_array($line[$i], $open)) {
            $stack[] = $close[array_search($line[$i], $open)];
        } else {
            // closing
            $expected = array_pop($stack);
            if ($line[$i] != $expected) {
                return [false, $line[$i]];
            }
        }
    }

    return [true];
}

$sum = 0;

foreach ($input as $line) {
    $check = checkLine(trim($line));
    if ($check[0] === false) {
        $sum += $values[$check[1]];
    }
}

echo $sum;
