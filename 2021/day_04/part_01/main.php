<?php
require '../Board.php';

$lines = file($argv[1]);
$line_count = count($lines);

$numbers = array_map(fn ($value) => intval($value), explode(',', $lines[0]));

$buffer = [];
$boards = [];

for ($i = 2; $i < $line_count; $i++) {
    $line = trim($lines[$i]);
    if (!empty($line)) {
        $buffer[] = array_map(fn ($value) => intval(trim($value)), explode(' ', str_replace('  ', ' ', $line)));
    }

    if (count($buffer) == 5) {
        $boards[] = new Board($buffer);
        $buffer = [];
    }
}

function findWinner($boards, $numbers) {
    foreach ($numbers as $number) {
        foreach ($boards as $board) {
            $finished = $board->pickNumber($number);
            if ($finished === true) {
                return $board;
            }
        }
    }
}

$winningBoard = findWinner($boards, $numbers);
echo $winningBoard->calculateScore();
