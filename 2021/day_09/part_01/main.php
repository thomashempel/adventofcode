<?php
$input = file($argv[1]);
$map = [];

$xd = strlen(trim($input[0]));
$yd = count($input);

foreach ($input as $line) {
    $map = array_merge($map, array_map(fn ($v) => intval($v), str_split(trim($line))));
}

$maxp = count($map) - 1;
$lowPoints = [];

// var_dump($map);

function streamPos(int $xd, int $x, int $y): int
{
    return ($y * $xd) + $x;
}

for ($y = 0; $y < $yd; $y++) {
    for ($x = 0; $x < $xd; $x++) {
        $v = $map[streamPos($xd, $x, $y)];

        $tp = streamPos($xd, $x, $y - 1);
        $bp = streamPos($xd, $x, $y + 1);
        $lp = streamPos($xd, $x - 1, $y);
        $rp = streamPos($xd, $x + 1, $y);

        // if ($tp < 0 || $lp < 0 || $bp > $maxp || $rp > $maxp) {
        //     continue;
        // }
        $tv = $tp >= 0 ? $map[$tp] : 99;
        $bv = $bp <= $maxp ? $map[$bp] : 99;
        $lv = $lp >= 0 ? $map[$lp] : 99;
        $rv = $rp <= $maxp ? $map[$rp] : 99;

        if ($v < $tv && $v < $bv && $v < $lv && $v < $rv) {
            $lowPoints[] = $v + 1;
        }
    }
}

echo array_sum($lowPoints);
