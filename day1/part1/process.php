<?php
$input = file('input.txt');
$result = 0;
$last = PHP_INT_MAX;

foreach ($input as $line) {
    $intLine = intval($line);
    if ($intLine > $last) {
        $result++;
    }
    $last = $intLine;
}

echo $result;
