<?php
$input = file($argv[1]);

function find($input) {
    foreach ($input as $a) {
        foreach ($input as $b) {
            if (intval($a) + intval($b) === 2020) {
                return intval($a) * intval($b);
            }
        }
    }
}

echo find($input);
