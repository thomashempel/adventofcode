<?php
$input = file($argv[1]);
$inputSize = count($input);

$result = 0;
$windowSize = 3;

function windowSum($data, $index, $size, $inputSize) {
    $sum = 0;
    for ($i = $index; $i < $index + $size; $i++) {
        if ($i < 0 || $i > $inputSize -1) {
            return false;
        }

        $sum += intval($data[$i]);
    }
    return $sum;
}

for ($li = 0; $li < $inputSize; $li++) {
    $sum1 = windowSum($input, $li, $windowSize, $inputSize);
    if ($sum1 === false) { break; }

    $sum2 = windowSum($input, $li + 1, $windowSize, $inputSize);
    if ($sum2 === false) { break; }

    if ($sum1 < $sum2) {
        $result++;
    }
}

echo $result;
