<?php
//
// I'm out! I have absolutely no idea what the question even is.
//

class Day18
{

    public function test()
    {

    }

    public function parse(string $input): array
    {
        $result = [];



        return $result;
    }

    public function reduce(string|array $input): string
    {
        if (is_string($input)) {
            $input = $this->parse($input);
        }

        return '';
    }

    public function part1()
    {
        $res = 'TBI';

        echo 'Part 1: ' . $res . "\n\n";
    }

    public function part2()
    {
        $res = 'TBI';

        echo 'Part 2: ' . $res . "\n\n";
    }
}

$day18 = new Day18();

assert($day18->reduce('[[[[[9,8],1],2],3],4]') == '[[[[0,9],2],3],4]');
assert($day18->reduce('[7,[6,[5,[4,[3,2]]]]]') == '[7,[6,[5,[7,0]]]]');
assert($day18->reduce('[[6,[5,[4,[3,2]]]],1]') == '[[6,[5,[7,0]]],3]');
assert($day18->reduce('[[3,[2,[1,[7,3]]]],[6,[5,[4,[3,2]]]]]') == '[[3,[2,[8,0]]],[9,[5,[4,[3,2]]]]]');
assert($day18->reduce('[[3,[2,[8,0]]],[9,[5,[4,[3,2]]]]]') == '[[3,[2,[8,0]]],[9,[5,[7,0]]]]');

$day18->part1();
$day18->part2();
