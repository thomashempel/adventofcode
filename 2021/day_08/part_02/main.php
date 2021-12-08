<?php
$input = file($argv[1]);

// Returns the number of different characters between two strings
function common($str1, $str2): int
{
    $common = 0;
    for ($i = 0; $i < strlen($str1); $i++) {
        if (strstr($str2, $str1[$i]) !== false) {
            $common++;
        }
    }
    return $common;
}

$sum = 0;

foreach ($input as $line) {
    list($input, $output) = explode(' | ', $line);
    $inputSegments = array_map(fn ($v) => trim($v), explode(' ', $input));
    $outputSegments = array_map(fn ($v) => trim($v), explode(' ', $output));

    // sort input segments by length of the elements
    $lengths = array_map('strlen', $inputSegments);
    array_multisort($lengths, SORT_ASC, $inputSegments);

    // prefill map with what we know
    $map = [
        0 => '',
        1 => $inputSegments[0],
        2 => '',
        3 => '',
        4 => $inputSegments[2],
        5 => '',
        6 => '',
        7 => $inputSegments[1],
        8 => $inputSegments[9],
        9 => '',
    ];

    // Now look at each input number and check the commonality to the known 1 and 4.
    // The number of different segements is unique in combination
    // Yeah, I had to look that up.
    foreach ($inputSegments as $scrambled) {
        $common1 = common($scrambled, $map[1]);
        $common4 = common($scrambled, $map[4]);

        switch (strlen($scrambled)) {
            case 4:
                if ($common1 == 2 && $common4 = 4) {
                    $map[4] = $scrambled;
                }
                break;
            case 5:
                if ($common1 == 1 && $common4 == 2) {
                    $map[2] = $scrambled;
                }
                if ($common1 == 2 && $common4 == 3) {
                    $map[3] = $scrambled;
                }
                if ($common1 == 1 && $common4 == 3) {
                    $map[5] = $scrambled;
                }
                break;
            case 6:
                if ($common1 == 1 && $common4 == 3) {
                    $map[6] = $scrambled;
                }
                if ($common1 == 2 && $common4 == 4) {
                    $map[9] = $scrambled;
                }
                if ($common1 == 2 && $common4 == 3) {
                    $map[0] = $scrambled;
                }
                break;
        }
    }

    $descrambled = '';

    // Finally match the 4 searched numbers with the map we just generated.
    foreach ($outputSegments as $lookup) {
        foreach ($map as $number => $scramble) {
            $ll = strlen($lookup);
            if (strlen($scramble) != $ll) {
                continue;
            }

            if (common($lookup, $scramble) == $ll) {
                $descrambled .= $number;
            }
        }
    }

    $sum += intval($descrambled);
}

echo $sum;
