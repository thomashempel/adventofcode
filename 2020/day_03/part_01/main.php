<?php
$input = file($argv[1]);
$lines = count($input);
$step = 3;
$trees = 0;

function isTree($line, $offset) {
    $x = $offset % strlen($line);
    return $line[$x] == '#';
}

for ($line = 0; $line < $lines; $line++) {
    if (isTree(trim($input[$line]), $line * $step)) {
        $trees++;
    }
}

echo $trees;
