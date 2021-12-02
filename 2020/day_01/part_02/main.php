<?php
$input = file($argv[1]);

function find($input) {
    foreach ($input as $a) {
        foreach ($input as $b) {
            foreach ($input as $c) {
                if (intval($a) + intval($b) + intval($c) === 2020) {
                    return intval($a) * intval($b) * intval($c);
                }
            }
        }
    }
}

echo find($input);
