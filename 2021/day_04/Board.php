<?php
declare(strict_types=1);

class Board
{
    const SIZE = 5;

    protected $data = [];
    protected $numbers = [];

    public $won = false;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function pickNumber(int $number): bool
    {
        $this->numbers[] = $number;
        return $this->isComplete();
    }

    public function isComplete(): bool
    {
        for ($i = 0; $i < self::SIZE; $i++) {
            $row = $this->checkRow($i);
            $col = $this->checkColumn($i);

            if ($row === true || $col === true) {
                $this->won = true;
                return true;
            }
        }

        return false;
    }

    protected function checkRow(int $row): bool
    {
        return $this->checkList($this->data[$row]);
    }

    protected function checkColumn(int $col): bool
    {
        $list = [];
        for ($i = 0; $i < self::SIZE; $i++) {
            $list[] = $this->data[$i][$col];
        }
        return $this->checkList($list);
    }

    protected function checkList(array $list): bool
    {
        $filtered = array_filter($list, fn ($n) => in_array($n, $this->numbers));
        return (count($filtered) == self::SIZE);
    }

    public function calculateScore(): int
    {
        $sum = 0;
        foreach ($this->data as $line) {
            foreach ($line as $number) {
                if (!in_array($number, $this->numbers)) {
                    $sum += $number;
                }
            }
        }
        return $sum * $this->numbers[count($this->numbers) -1];
    }
}
