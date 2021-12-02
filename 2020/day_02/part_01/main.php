<?php
$input = file($argv[1]);

function check(string $policy, string $password): bool {
    list($limits, $character) = explode(' ', $policy);
    list($min, $max) = explode('-', $limits);
    $count = substr_count(trim($password), $character);
    return ($count >= intval($min) && $count <= intval($max));
}

$valid = 0;

foreach ($input as $line) {
    list($policy, $password) = explode(': ', $line);
    if (check($policy, $password)) {
        $valid++;
    }
}

echo $valid;
