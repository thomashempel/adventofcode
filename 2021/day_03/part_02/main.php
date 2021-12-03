<?php
$input = file($argv[1]);
$line_size = strlen($input[0]);

$line_size = strlen(trim($input[0]));

function countBits(array $data, int $line_size): array {
    $counts = array_fill(0, $line_size, [0 => 0, 1 => 0]);

    foreach ($data as $line) {
        for ($i = 0; $i < $line_size; $i++) {
            $val = intval($line[$i]);
            $counts[$i][$val]++;
        }
    }

    return $counts;
}

function extractLine(array $data, int $line_size, bool $common = true): string
{
    $remaining = $data;
    $bit_index = 0;

    do {
        $counts = countBits($remaining, $line_size);
        $keep = '';

        if ($counts[$bit_index][0] > $counts[$bit_index][1]) {
            $keep = $common ? '0' : '1';
        } else {
            $keep = $common ? '1' : '0';
        }

        $new = [];
        foreach ($remaining as $line) {
            if ($line[$bit_index] == $keep) {
                $new[] = $line;
            }
        }

        $remaining = $new;
        $bit_index++;
    } while (count($remaining) > 1);

    return $remaining[0];
}

$oxygen_generator_rating = extractLine($input, $line_size, true);
$co2_scrubber_rating = extractLine($input, $line_size, false);

echo bindec($oxygen_generator_rating) * bindec($co2_scrubber_rating);
