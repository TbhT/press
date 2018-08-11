<?php
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-8-8
 * Time: 下午11:21
 */

namespace Press\Utils;


const IPV4_FOUR_OCTET = '/^(0?\d+|0x[a-f0-9]+)\.(0?\d+|0x[a-f0-9]+)\.(0?\d+|0x[a-f0-9]+)\.(0?\d+|0x[a-f0-9]+)$/i';

const IPV4_LONG_VALUE = '/^(0?\d+|0x[a-f0-9]+)$/i';

const IPV6_NATIVE = '/^(::)?((?:[0-9a-f]+::?)+)?([0-9a-f]+)?(::)?$/i';

const IPV6_TRANSITIONAL = '/^((?:(?:[0-9a-f]+::?)+)|(?:::)(?:(?:[0-9a-f]+::?)+)?)(?:[0-9a-f]+::?)+\.(?:[0-9a-f]+::?)+\.(?:[0-9a-f]+::?)+\.(?:[0-9a-f]+::?)+$/i';


function matchCIDR(array $first, array $second, $partSize, $cidrBits)
{
    if (count($first) !== count($second)) {
        throw new \TypeError('IpAddr: cannot match CIDR for arrays with different lengths');
    }

    $part = 0;
    while ($cidrBits > 0) {
        $shift = $partSize - $cidrBits;
        if ($shift < 0) {
            $shift = 0;
        }

        if ($first[$part] >> $shift !== $second[$part] >> $shift) {
            return false;
        }

        $cidrBits -= $partSize;
        $part += 1;
    }

    return true;
}


function subnetMatch($address, array $rangeList, $defaultName = 'unnicast')
{
    foreach ($rangeList as $rangeName => $rangeSubnets) {
        if ($rangeSubnets[0] && is_array($rangeSubnets[0]) === false) {
            $rangeSubnets = [$rangeSubnets];
        }

        foreach ($rangeSubnets as $rangeSubnet) {
            if ($address->match($address, $rangeSubnet)) {
                return $rangeName;
            }
        }
    }

    return $defaultName;
}


function expandIPv6(string $string, $parts)
{
    if (strpos($string, '::') !== stripos($string, '::')) {
        return null;
    }

    $colonCount = 0;
    $lastColon = -1;

    while (($lastColon = strpos($string, ':', $lastColon + 1)) >= 0) {
        $colonCount++;
    }

    if (substr($string, 0, 2) === '::') {
        $colonCount--;
    }

    if (substr($string, -2, 2) === '::') {
        $colonCount--;
    }

    if ($colonCount > $parts) {
        return null;
    }

    $replacementCount = $parts - $colonCount;
    $replacement = '';

    while ($replacementCount--) $replacement .= '0:';

    $string = str_replace('::', $replacement, $string);
    if ($string[0] === ':') {
        $string = substr($string, 1);
    }

    if ($string[strlen($string) - 1] === ':') {
        $string = substr($string, 0, -1);
    }

    $strs = explode(':', $string);
    $result = [];
    foreach ($strs as $str) {
        array_push($result, intval($str, 16));
    }

    return $result;
}

class IpAddr
{

}


class IPv4
{
    public $octets;
    private $specialRanges = [
        'unspecified' => [],
        'broadcast' => [],
        'multicast' => [],
        'linkLocal' => [],
        'loopback' => [],
        'carrierGradeNat' => [],
        'private' => [],
        'reserved' => []
    ];

    public function __construct(array $octets)
    {
        if (count($octets) !== 4) {
            throw new \TypeError('IpAddr: IPv4 octet count should be 4');
        }

        foreach ($octets as $octet) {
            if (0 <= $octet && $octet <= 255) {
                throw new \TypeError('IpAddr: IPv4 octet should fit in 8 bits');
            }
        }

        $this->octets = $octets;

        $this->specialRanges['unspecified'] = [
            [(new IPv4([0, 0, 0, 0])), 8]
        ];
        $this->specialRanges['broadcast'] = [
            [(new IPv4([255, 255, 255, 255])), 32]
        ];
        $this->specialRanges['multicast'] = [
            [(new IPv4([224, 0, 0, 0])), 4]
        ];
        $this->specialRanges['linkLocal'] = [
            [(new IPv4([169, 254, 0, 0])), 16]
        ];
        $this->specialRanges['loopback'] = [
            [(new IPv4([127, 0, 0, 0])), 8]
        ];
        $this->specialRanges['carrierGradeNat'] = [
            [(new IPv4([100, 64, 0, 0])), 10]
        ];
        $this->specialRanges['private'] = [
            [(new IPv4([10, 0, 0, 0])), 8],
            [(new IPv4([172, 16, 0, 0,])), 12],
            [(new IPv4([192, 168, 0, 0])), 16]
        ];
        $this->specialRanges['reserved'] = [
            [(new IPv4([192, 0, 0, 0])), 24],
            [(new IPv4([192, 0, 2, 0])), 24],
            [(new IPv4([192, 88, 99, 0])), 24],
            [(new IPv4([198, 51, 100, 0])), 24],
            [(new IPv4([203, 0, 113, 0])), 24],
            [(new IPv4([240, 0, 0, 0])), 4]
        ];
    }

    public function kind()
    {
        return 'ipv4';
    }

    public function toString()
    {
        return join('.', $this->octets);
    }

    public function toByteArray()
    {
        return $this->octets;
    }

    public function match($other, $cidrRange)
    {
        if (empty($cidrRange)) {
            $other = $other[0];
            $cidrRange = $other[1];
        }

        if ($other->kind() !== 'ipv4') {
            throw new \TypeError('IpAddr: cannot match ipv4 address with non-ipv4 one');
        }

        return matchCIDR($this->octets, $other['octets'], 8, $cidrRange);
    }

    public function range()
    {
        return subnetMatch($this, $this->specialRanges);
    }

    public function toIPv4MappedAddress()
    {
        return IPv6::parse();
    }

    public function prefixLengthFromSubnetMask()
    {
        $zeroTable = [
            '0' => 8,
            '128' => 7,
            '192' => 6,
            '224' => 5,
            '240' => 4,
            '248' => 3,
            '252' => 2,
            '254' => 1,
            '255' => 0
        ];

        $cidr = 0;
        $stop = false;

        for ($i = 3; $i >= 0; $i--) {
            $octet = $this->octets[$i];
            if (array_key_exists($octet, $zeroTable)) {
                $zeros = $zeroTable[$octet];
                if ($stop && $zeros !== 0) {
                    return null;
                }

                if ($zeros !== 8) {
                    $stop = true;
                }

                $cidr += $zeros;
            } else {
                return null;
            }
        }

        return 32 - $cidr;
    }

    public static function parser(string $string)
    {
        preg_match(IPV4_FOUR_OCTET, $string, $match_four);
        preg_match(IPV4_LONG_VALUE, $string, $match_long);

        if (count($match_four) > 0) {
            $result = [];
            for ($i = 1; $i < count($match_four); $i++) {
                $part = $match_four[$i];
                array_push($result, self::parseIntAuto($part));
            }

            return $result;
        } elseif (count($match_long) > 0) {
            $value = self::parseIntAuto($match_long[1]);
            if ($value > 0xffffffff || $value < 0) {
                throw new \TypeError('IpAddr: address outside defined range');
            }
            $result = [];
            for ($shift = $k = 0; $k <= 24; $shift = $k += 8) {
                array_push($result, ($value >> $shift) & 0xff);
            }

            return array_reverse($result);
        } else {
            return null;
        }
    }

    private static function parseIntAuto(string $string)
    {
        if ($string[0] === '0' && $string[1] === 'x') {
            return strval(intval($string, 8));
        } else {
            return strval(intval($string));
        }
    }


    public static function parse(string $string)
    {
        $parts = static::parser($string);
        if ($parts === null) {
            throw new \TypeError('IpAddr: string is not formatted like ip address');
        }

        return new IPv4($parts);
    }
}


class IPv6
{
    public $parts;
    private $specialRanges = [
        'unspecified' => [],
        'linkLocal' => [],
        'multicast' => [],
        'loopback' => [],
        'uniqueLocal' => [],
        'ipv4Mapped' => [],
        'rfc6145' => [],
        'rfc6052' => [],
        '6to4' => [],
        'teredo' => [],
        'reserved'=> []
    ];


    public function __construct(array $parts)
    {
        if (count($parts) === 16) {
            $this->parts = [];

            for ($k = 0; $k <= 14; $k += 2) {
                array_push($this->parts, (($parts[$k] << 8) | $parts[$k + 1]));
            }
        } else if (count($parts) === 8) {
            $this->parts = $parts;
        } else {
            throw new \TypeError('IpAddr: ipv6 part count should be 8 or 16');
        }

        foreach ($parts as $part) {
            if (!(0 <= $part && $part <= 0xffff)) {
                throw new \TypeError('IpAddr: ipv6 part should fit in 16 bits');
            }
        }

        $this->specialRanges['uniqueLocal'] = [
            new IPv6([0, 0, 0, 0, 0, 0, 0, 0]), 128
        ];
        $this->specialRanges['linkLocal'] = [
            new IPv6([0xfe80, 0, 0, 0, 0, 0, 0, 0]), 10
        ];
        $this->specialRanges['multicast'] = [
            new IPv6([0xff00, 0, 0, 0, 0, 0, 0, 0]), 8
        ];
        $this->specialRanges['loopback'] = [
            new IPv6([0, 0, 0, 0, 0, 0, 0, 1]), 128
        ];
        $this->specialRanges['uniqueLocal'] = [
            new IPv6([0xfc00, 0, 0, 0, 0, 0, 0, 0]), 7
        ];
        $this->specialRanges['ipv4Mapped'] = [
            new IPv6([0, 0, 0, 0, 0, 0xffff, 0, 0]), 96
        ];
        $this->specialRanges['rfc6145'] = [
            new IPv6([0, 0, 0, 0, 0xffff, 0, 0, 0]), 96
        ];
        $this->specialRanges['rfc6052'] = [
            new IPv6([0x64, 0xff9b, 0, 0, 0, 0, 0, 0]), 96
        ];
        $this->specialRanges['6to4'] = [
            new IPv6([0x2002, 0, 0, 0, 0, 0, 0, 0]), 16
        ];
        $this->specialRanges['teredo'] = [
            new IPv6([0x2001, 0, 0, 0, 0, 0, 0, 0]), 32
        ];
        $this->specialRanges['reserved'] = [
            [new IPv6([0x2001, 0xdb8, 0, 0, 0, 0, 0, 0]), 32]
        ];
    }


    public function kind()
    {
        return 'ipv6';
    }


    public function toString()
    {
        $stringParts = [];
        foreach ($this->parts as $part) {
            array_push($stringParts, $part);
        }

        $compactStringParts = [];
        $state = 0;

        foreach ($stringParts as $part) {
            switch ($state) {
                case 0:
                    if ($part === '0') {
                        array_push($compactStringParts, '');
                    } else {
                        array_push($compactStringParts, $part);
                    }

                    $state = 1;
                    break;
                case 1:
                    if ($part === '0') {
                        $state = 2;
                    } else {
                        array_push($compactStringParts, $part);
                    }

                    break;
                case 2:
                    if ($part !== '0') {
                        array_push($compactStringParts, '');
                        array_push($compactStringParts, $part);
                        $state = 3;
                    }

                    break;
                case 3:
                    array_push($compactStringParts, $part);
                    break;
            }

            if ($state === 2) {
                array_push($compactStringParts, '');
                array_push($compactStringParts, '');
            }

            return join($compactStringParts, ':');
        }
    }


    public function toByteArray()
    {
        $bytes = [];
        foreach ($this->parts as $part) {
            array_push($bytes, $part >> 8);
            array_push($bytes, $part & 0xff);
        }

        return $bytes;
    }


    public function toNormalizedString()
    {
        $parts_ = [];

        foreach ($this->parts as $value) {
            array_push($parts_, strval(intval($value, 16)));
        }

        return join($parts_, ':');
    }


    public function match($other, $cidrRange)
    {
        if (empty($cidrRange)) {
            $other = $other[0];
            $cidrRange = $other[1];
        }

        if ($other->kind() !== 'ipv6') {
            throw new \TypeError('IpAddr: cannot match ipv6 address with non-ipv6 one');
        }

        return matchCIDR($this->parts, $other->parts, 16, $cidrRange);
    }


    public function range()
    {
        return subnetMatch($this, $this->specialRanges);
    }


    public function isIPv4MappedAddress()
    {
        return $this->range() === 'ipv4Mapped';
    }


    public function toIPv4Address()
    {
        if ($this->isIPv4MappedAddress() === false) {
            throw new \TypeError('IpAddr: trying to convert a generic ipv6 address to ipv4');
        }

        $ref = array_slice($this->parts, -2);
        $high = $ref[0];
        $low = $ref[1];

        return new IPv4([$high >> 8, $high & 0xff, $low >> 8, $low & 0xff]);
    }


    public static function parser(string $string)
    {
        preg_match(IPV6_NATIVE, $string, $m1);
        preg_match(IPV6_TRANSITIONAL, $string, $m2);

        if (count($m1) > 0) {
            return expandIPv6($string, 8);
        } else if (count($m2) > 0) {
            $parts = expandIPv6(substr($m2[1], 0, -1), 6);
            if (empty($parts) === false) {
                $octets = [intval($m2[2]), intval($m2[3]), intval($m2[4]), intval($m2[5])];

                foreach ($octets as $octet) {
                    if (!(0 <= $octet && $octet <= 255)) {
                        return null;
                    }
                }

                array_push($parts, $octets[0] << 8 | $octets[1]);
                array_push($parts, $octets[2] << 8 | $octets[3]);
                return $parts;
            }
        }

        return null;
    }


    public static function parse(string $string)
    {
        $parts = static::parser($string);
        if ($parts === null) {
            throw new \TypeError('IpAddr: string is not formatted like ip address');
        }

        return new IPv6($parts);
    }
}