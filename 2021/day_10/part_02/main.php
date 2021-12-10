<?php
$input = file($argv[1]);

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

    return [true, $stack];
}

$sum = 0;

$values = [
    ')' => 1,
    ']' => 2,
    '}' => 3,
    '>' => 4
];

$scores = [];

foreach ($input as $line) {
    $check = checkLine(trim($line));
    if ($check[0] === true) {
        $sum = 0;
        $stackSize = count($check[1]);
        for ($i = 0; $i < $stackSize; $i++) {
            $char = array_pop($check[1]);
            $sum *= 5;
            $sum += $values[$char];
        }
        $scores[] = $sum;
    }
}

sort($scores);
echo $scores[floor(count($scores) / 2)];
