<?php
$input = file($argv[1]);

function check(string $policy, string $password): bool {
    list($positions, $character) = explode(' ', $policy);
    list($pos1, $pos2) = explode('-', $positions);
    $c1 = substr($password, intval($pos1) - 1, 1);
    $c2 = substr($password, intval($pos2) - 1, 1);
    return (($c1 == $character) xor ($c2 == $character));
}

$valid = 0;

foreach ($input as $line) {
    list($policy, $password) = explode(': ', $line);
    if (check($policy, $password)) {
        $valid++;
    }
}

echo $valid;
