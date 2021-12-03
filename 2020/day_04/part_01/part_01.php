<?php

const MANDATORY_FIELDS = ['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'];

$input = file($argv[1]);
$size = count($input);
$valid = 0;
$passport = [];

function checkFields(array $existing): bool
{
    foreach (MANDATORY_FIELDS as $mf) {
        if (!in_array($mf, $existing)) {
            return false;
        }
    }
    return true;
}

for ($i = 0; $i < $size; $i++) {
    $trimmed = trim($input[$i]);
    $passport = array_merge($passport, explode(' ', $trimmed));

    if ($i == ($size - 1) || empty($trimmed)) {
        // new line, or last line, check passport
        $existing = array_map(fn($row) => explode(':', $row)[0], $passport);
        $passport = [];

        if (checkFields($existing)) {
            $valid++;
        }
    }
}

echo $valid;
