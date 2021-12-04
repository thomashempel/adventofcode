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


function calcBoards($boards, $numbers) {
    $winningBoards = [];
    $boardCount = count($boards);

    foreach ($numbers as $number) {
        foreach ($boards as $bid => $board) {
            if ($board->won) {
                continue;
            }

            $finished = $board->pickNumber($number);
            if ($finished === true) {
                $winningBoards[] = $board;

                if (count($winningBoards) == $boardCount) {
                    return $winningBoards;
                }
            }
        }
    }

    return $winningBoards;
}

$calculatedBoards = calcBoards($boards, $numbers);
$loosingBoard = array_pop($calculatedBoards);

echo $loosingBoard->calculateScore();
