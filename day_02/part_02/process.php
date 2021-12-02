<?php
const H_POS = 'h';
const DEPTH = 'd';
const AIM = 'a';

$input = file('../input.txt');
$inputSize = count($input);

$pos = [H_POS => 0, DEPTH => 0, AIM => 0];


foreach ($input as $line) {
    list($command, $x) = explode(' ', $line);
    switch ($command) {
        case 'forward':
            $pos[H_POS] += intval($x);
            $pos[DEPTH] += $pos[AIM] * intval($x);
            break;
        case 'down':
            $pos[AIM] += intval($x);
            break;
        case 'up':
            $pos[AIM] -= intval($x);
            break;
    }
}

echo $pos[DEPTH] * $pos[H_POS];
