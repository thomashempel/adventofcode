<?php


class Part02
{
    private $map = [];

    private $xd = 0;
    private $yd = 0;

    private $maxp = 0;
    private $lowPoints = [];

    public function init($file) {
        $input = file($file);

        $this->xd = strlen(trim($input[0]));
        $this->yd = count($input);

        foreach ($input as $line) {
            $this->map = array_merge($this->map, array_map(fn ($v) => intval($v), str_split(trim($line))));
        }

        $this->maxp = count($this->map) - 1;
    }

    public function streamPos(int $x, int $y): int
    {
        if ($x < 0 || $x > $this->xd - 1 || $y < 0 || $y > $this->yd - 1) {
            return -1;
        }
        return ($y * $this->xd) + $x;
    }

    public function streamValue(int $x, int $y, int $def = 99): int
    {
        $pos = $this->streamPos($x, $y);
        return ($pos >= 0 && $pos <= $this->maxp) ? $this->map[$pos] : $def;
    }

    public function findLowPoints()
    {
        for ($y = 0; $y < $this->yd; $y++) {
            for ($x = 0; $x < $this->xd; $x++) {
                $v = $this->streamValue($x, $y);

                $tv = $this->streamValue($x, $y - 1);
                $bv = $this->streamValue($x, $y + 1);
                $lv = $this->streamValue($x - 1, $y);
                $rv = $this->streamValue($x + 1, $y);

                if ($v < $tv && $v < $bv && $v < $lv && $v < $rv) {
                    $this->lowPoints[] = ['x' => $x, 'y' => $y];
                }
            }
        }

    }

    private function key(array $point): string
    {
        return $point['x'].'x'.$point['y'];
    }

    private function lookup($c, $found): array
    {
        $p = ['x' => $c['x'], 'y' => $c['y'] - 1];
        $pk = $this->key($p);
        if (!array_key_exists($pk, $found) && $this->streamValue($p['x'], $p['y']) < 9) {
            $found[$pk] = true;
            $found = $this->lookup($p, $found);
        }

        $p = ['x' => $c['x'], 'y' => $c['y'] + 1];
        $pk = $this->key($p);
        if (!array_key_exists($pk, $found) && $this->streamValue($p['x'], $p['y']) < 9) {
            $found[$pk] = true;
            $found = $this->lookup($p, $found);
        }

        $p = ['x' => $c['x'] - 1, 'y' => $c['y']];
        $pk = $this->key($p);
        if (!array_key_exists($pk, $found) && $this->streamValue($p['x'], $p['y']) < 9) {
            $found[$pk] = true;
            $found = $this->lookup($p, $found);
        }

        $p = ['x' => $c['x'] + 1, 'y' => $c['y']];
        $pk = $this->key($p);
        if (!array_key_exists($pk, $found) && $this->streamValue($p['x'], $p['y']) < 9) {
            $found[$pk] = true;
            $found = $this->lookup($p, $found);
        }

        return $found;
    }

    public function run()
    {
        $this->findLowPoints();
        $counts = [];

        foreach ($this->lowPoints as $center) {
            $found = [];
            $found[$this->key($center)] = true;
            $found = $this->lookup($center, $found);

            $counts[] = count($found);
        }

        rsort($counts, );
        echo array_product(array_slice($counts, 0, 3));

    }
}

$instance = new Part02();
$instance->init($argv[1]);
$instance->run();
