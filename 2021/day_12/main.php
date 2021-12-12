<?php
class Day12
{
    private array $nodes = [
        'start' => [false, []],
        'end' => [false, []]
    ];

    public function __construct($file)
    {
        $input = file($file);
        foreach ($input as $connection) {
            list($node1, $node2) = explode('-', trim($connection));

            if (!array_key_exists($node1, $this->nodes)) {
                $this->nodes[$node1] = [($node1 == strtoupper($node1)), []];
            }
            if (!array_key_exists($node2, $this->nodes)) {
                $this->nodes[$node2] = [($node2 == strtoupper($node2)), []];
            }

            $this->nodes[$node1][1] = array_merge($this->nodes[$node1][1], [$node2]);
            $this->nodes[$node2][1] = array_merge($this->nodes[$node2][1], [$node1]);
        }
        // var_dump($this->nodes);
    }

    private function nextRoom(&$paths, $currentRoom, $path = [])
    {
        $path[] = $currentRoom;

        if ($currentRoom == 'end') {
            $paths[] = $path;
            return $path;
        }

        $connectedRooms = $this->nodes[$currentRoom][1];

        foreach ($connectedRooms as $nextRoom) {
            $isBig = $this->nodes[$nextRoom][0];

            if ($isBig || (!$isBig && !in_array($nextRoom, $path))) {
                $this->nextRoom($paths, $nextRoom, $path);
            }
        }
    }

    private function anySmallDouble($segments, $path): bool
    {
        foreach ($segments as $s => $c) {
            if ($this->nodes[$s][0] == false && $c == 2) {
                return true;
            }
        }
        return false;
    }

    private function nextRoomPart2(&$paths, $currentRoom, $path = [])
    {
        $path[] = $currentRoom;

        if ($currentRoom == 'end') {
            $paths[] = $path;
            return $path;
        }

        $connectedRooms = $this->nodes[$currentRoom][1];

        foreach ($connectedRooms as $nextRoom) {
            if ($nextRoom == 'start') {
                continue;
            }

            $canVisit = true;

            if ($this->nodes[$nextRoom][0] == false) {
                // small room
                $segments = array_count_values($path);
                if (array_key_exists($nextRoom, $segments)) {
                    $canVisit = !$this->anySmallDouble($segments, $path);
                }
            }

            if ($canVisit) {
                $this->nextRoomPart2($paths, $nextRoom, $path);
            }
        }
    }

    public function part1()
    {
        $paths = [];
        $this->nextRoom($paths, 'start');
        // foreach ($paths as $path) {
        //     echo json_encode($path) . "\n";
        // }

        echo 'Part 1: ' . count($paths) . "\n\n";
    }

    public function part2()
    {
        $paths = [];
        $this->nextRoomPart2($paths, 'start');
        // foreach ($paths as $path) {
        //     echo json_encode($path) . "\n";
        // }

        echo 'Part 2: ' . count($paths) . "\n\n";
    }
}

$day11 = new Day12($argv[1]);
$day11->part1();
$day11->part2();
