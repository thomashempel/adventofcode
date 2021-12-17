<?php
class Day16
{
    protected $input = '';

    const HEX_MAP = [
        '0' => '0000',
        '1' => '0001',
        '2' => '0010',
        '3' => '0011',
        '4' => '0100',
        '5' => '0101',
        '6' => '0110',
        '7' => '0111',
        '8' => '1000',
        '9' => '1001',
        'A' => '1010',
        'B' => '1011',
        'C' => '1100',
        'D' => '1101',
        'E' => '1110',
        'F' => '1111',
    ];

    public function __construct($file)
    {
        $input = file($file);
        $this->input = $this->hex2bin(strtoupper(trim($input[0])));
    }

    /**
     * We do the conversion ourself, since base_convert works
     * with numbers and therefore strips leading zeros. But we
     * need those.
     */
    public function hex2bin($hex): string
    {
        return implode(array_map(fn ($c) => self::HEX_MAP[$c], str_split($hex)));
    }

    protected function fetch($data, $length): array
    {
        return [
            substr($data, 0, $length),
            substr($data, $length)
        ];
    }

    protected function parseLiteral(string $input, array $packet): array
    {
        $packet['d'] = '';
        do {
            [$g, $input] = $this->fetch($input, 5);
            $endOfPacket = $g[0] == '0';
            $packet['d'] .= substr($g, 1);
        }   while ($endOfPacket === false);

        $packet['dec'] = bindec($packet['d']);

        return [$input, $packet];
    }

    protected function parseOperator(string $input, array $packet): array
    {
        [$l, $input] = $this->fetch($input, 1);
        $packet['l'] = intval($l);

        if ($packet['l'] == 0) {
            // the next 15 bits are a number that represents the total length
            // in bits of the sub-packets contained by this packet.
            [$length, $input] = $this->fetch($input, 15);
            $length = bindec($length);
            [$sub, $input] = $this->fetch($input, $length);
            $packet['sub'] = $this->parse($sub);
        } else {
            // the next 11 bits are a number that represents the number of
            // sub-packets immediately contained by this packet.
            [$number, $input] = $this->fetch($input, 11);
            $number = bindec($number);
            $packet['n'] = $number;
            for ($i = 0; $i < $number; $i++) {
                [$input, $subPacket] = $this->parsePacket($input);
                $packet['sub'][] = $subPacket;
            }
        }

        return [$input, $packet];
    }

    public function parsePacket(string $input): array
    {
        // version
        [$v, $input] = $this->fetch($input, 3);
        [$t, $input] = $this->fetch($input, 3);

        $packet = [
            'v' => bindec($v),
            't' => bindec($t),
        ];

        switch ($packet['t']) {
            case 4:
                [$input, $packet] = $this->parseLiteral($input, $packet);
                break;
            default:
                [$input, $packet] = $this->parseOperator($input, $packet);
                break;
        }

        return [$input, $packet];
    }

    public function parse(string $input): array
    {
        $packets = [];

        do {
            [$input, $packet] = $this->parsePacket($input);
            $packets[] = $packet;
        } while (strpos($input, '1') !== false);

        return $packets;
    }

    public function versionChecksum(array $packets, int $sum = 0): int
    {
        foreach ($packets as $p) {

            $sum += $p['v'];

            if (array_key_exists('sub', $p)) {
                $sum = $this->versionChecksum($p['sub'], $sum);
            }
        }
        return $sum;
    }

    public function value(array $packets): int
    {
        $sum = 0;
        foreach ($packets as $p) {
            $sum += $this->packetValue($p);
        }
        return $sum;
    }

    public function packetValue(array $packet): int
    {
        if ($packet['t'] == 4) {
            return $packet['dec'];
        }

        $values = [];

        foreach ($packet['sub'] as $p) {
            $values[] = $this->packetValue($p);
        }

        switch ($packet['t']) {
            case 0:
                return array_sum($values);

            case 1:
                return array_product($values);

            case 2:
                return min($values);

            case 3:
                return max($values);

            case 5:
                return ($values[0] > $values[1]) ? 1 : 0;

            case 6:
                return ($values[0] < $values[1]) ? 1 : 0;

            case 7:
                return ($values[0] == $values[1]) ? 1 : 0;
        }
    }

    public function part1()
    {
        $packets = $this->parse($this->input);

        echo 'Part 1: ' . $this->versionChecksum($packets) . "\n\n";
    }

    public function part2()
    {
        $res = $this->value($this->parse($this->input));
        echo 'Part 2: ' . $res . "\n\n";
    }
}

$day16 = new Day16($argv[1]);
$day16->part1();
$day16->part2();

// Part 1 - Tests
// var_dump($day16->parse($day16->hex2bin('D2FE28')));
// var_dump($day16->parse($day16->hex2bin('38006F45291200')));
// var_dump($day16->parse($day16->hex2bin('EE00D40C823060')));
// var_dump($day16->versionChecksum($day16->parse($day16->hex2bin('8A004A801A8002F478'))));
// var_dump($day16->versionChecksum($day16->parse($day16->hex2bin('620080001611562C8802118E34'))));
// var_dump($day16->versionChecksum($day16->parse($day16->hex2bin('C0015000016115A2E0802F182340'))));
// var_dump($day16->versionChecksum($day16->parse($day16->hex2bin('A0016C880162017C3686B18A3D4780'))));

// Part 2 Tests
// var_dump($day16->value($day16->parse($day16->hex2bin('C200B40A82'))));
// var_dump($day16->value($day16->parse($day16->hex2bin('04005AC33890'))));
// var_dump($day16->value($day16->parse($day16->hex2bin('880086C3E88112'))));
// var_dump($day16->value($day16->parse($day16->hex2bin('CE00C43D881120'))));
// var_dump($day16->value($day16->parse($day16->hex2bin('D8005AC2A8F0'))));
// var_dump($day16->value($day16->parse($day16->hex2bin('F600BC2D8F'))));
// var_dump($day16->value($day16->parse($day16->hex2bin('9C005AC2F8F0'))));
// var_dump($day16->value($day16->parse($day16->hex2bin('9C0141080250320F1802104A08'))));
