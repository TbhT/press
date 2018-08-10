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


function subnetMatch(IPv4 $address, array $rangeList, $defaultName = 'unnicast')
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

        if ($this->kind() !== 'ipv4') {
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
            return intval($string, 8);
        } else {
            return intval($string);
        }
    }
}


class IPv6
{

}