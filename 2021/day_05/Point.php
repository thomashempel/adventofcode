<?php

class Point
{
    public $x = 0;
    public $y = 0;

    public function __construct(int $x = 0, int $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function fromString(string $s)
    {
        list($this->x, $this->y) = array_map(fn ($v) => intval($v), explode(',', trim($s)));
    }
}
