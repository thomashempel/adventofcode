<?php
require_once '../Point.php';

class Line
{
    public Point $from;
    public Point $to;

    public function __construct(string $p1, string $p2)
    {
        $this->from = new Point();
        $this->to = new Point();

        $this->fromStrings($p1, $p2);
    }

    public function fromStrings(string $p1, string $p2)
    {
        $this->from->fromString($p1);
        $this->to->fromString($p2);
    }

    public function diff(bool $absolute = false): Point {
        if ($absolute) {
            return new Point(
                abs($this->to->x - $this->from->x),
                abs($this->to->y - $this->from->y)
            );
        } else {
            new Point(
                $this->to->x - $this->from->x,
                $this->to->y - $this->from->y
            );
        }
    }

    public function isStraight(bool $includeDiagonal = false): bool {
        if ($includeDiagonal) {
            $diff = $this->diff(true);

            return (
                $this->from->x == $this->to->x ||   // Horizontal
                $this->from->y == $this->to->y ||   // Vertical
                $diff->x == $diff->y                // Diagonal
            );
        } else {
            return (
                $this->from->x == $this->to->x ||   // Horizontal
                $this->from->y == $this->to->y      // Vertical
            );
        }
    }

    public function getPoints(): array
    {
        $points = [];

        $diff = [
            'x' => $this->to->x - $this->from->x,
            'y' => $this->to->y - $this->from->y
        ];

        // echo "Diff: " . json_encode($diff) ."\n";

        $xStep = 0;
        if ($this->from->x != $this->to->x) {
            $xStep = ($this->from->x > $this->to->x) ? -1 : +1;
        }

        $yStep = 0;
        if ($this->from->y != $this->to->y) {
            $yStep = ($this->from->y > $this->to->y) ? -1 : +1;
        }

        $stepCount = abs($diff[(abs($xStep) >= abs($yStep)) ? 'x' : 'y']);

        // echo 'Steps: ' . json_encode([$xStep, $yStep, $stepCount]) . "\n";

        for ($s = 0; $s <= $stepCount; $s++) {
            $points[] = $this->getKey(
                $this->from->x + ($s * $xStep),
                $this->from->y + ($s * $yStep)
            );
        }

        return $points;
    }

    private function getKey($x, $y): string {
        return $x . 'x' . $y;
    }

    public function __toString()
    {
        return '[' . $this->from->x . 'x' . $this->from->y .'] -> [' . $this->to->x . 'x' . $this->to->y . ']';
    }
}
