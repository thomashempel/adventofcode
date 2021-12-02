<?php
const H_POS = 'h';
const DEPTH = 'd';

$input = file($argv[1]);
$inputSize = count($input);

$pos = [H_POS => 0, DEPTH => 0];

foreach ($input as $line) {
    list($command, $x) = explode(' ', $line);
    switch ($command) {
        case 'forward':
            $pos[H_POS] += intval($x);
            break;
        case 'down':
            $pos[DEPTH] += intval($x);
            break;
        case 'up':
            $pos[DEPTH] -= intval($x);
            break;
    }
}

echo $pos[DEPTH] * $pos[H_POS];
