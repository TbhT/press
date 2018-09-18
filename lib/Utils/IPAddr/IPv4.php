<?php
declare(strict_types=1);

namespace Press\Utils\IPAddr;


const IPV4_FOUR_OCTET = '/^(0?\d+|0x[a-f0-9]+)\.(0?\d+|0x[a-f0-9]+)\.(0?\d+|0x[a-f0-9]+)\.(0?\d+|0x[a-f0-9]+)$/i';

const IPV4_LONG_VALUE = '/^(0?\d+|0x[a-f0-9]+)$/i';


class IPv4
{
    public $octets;
    private $specialRangesArray = [
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
            if (!(0 <= $octet && $octet <= 255)) {
                throw new \TypeError('IpAddr: IPv4 octet should fit in 8 bits');
            }
        }

        $this->octets = $octets;
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


    public function match($other, $cidrRange = null)
    {
        if ($cidrRange === null) {
            $cidrRange = $other[1];
            $other = $other[0];
        }

        if ($other->kind() !== 'ipv4') {
            throw new \TypeError('IpAddr: cannot match ipv4 address with non-ipv4 one');
        }

        return Tool::matchCIDR($this->octets, $other->octets, 8, $cidrRange);
    }


    public function range()
    {
        return Tool::subnetMatch($this, $this->specialRanges);
    }


    public function toIPv4MappedAddress()
    {
        $str = $this->toString();
        return IPv6::parse("::ffff:{$str}");
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
        return strval(intval($string, 0));
    }


    public static function parse(string $string)
    {
        $parts = static::parser($string);
        if ($parts === null) {
            throw new \TypeError('IpAddr: string is not formatted like ip address');
        }

        return new IPv4($parts);
    }


    public static function isIPv4(string $string)
    {
        return static::parser($string) !== null;
    }


    public static function isValid($str)
    {
        try {
            new IPv4(static::parser($str));
            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }


    public static function isValidFourPartDecimal(string $str)
    {
        preg_match('/^\d+(\.\d+){3}$/', $str, $m);
        if (static::isIPv4($str) && count($m) > 0) {
            return true;
        } else {
            return false;
        }
    }


    public static function parseCIDR(string $string)
    {
        preg_match('/^(.+)\/(\d+)$/', $string, $m);
        if (count($m) > 0) {
            $maskLength = intval($m[2]);
            if ($maskLength >= 0 && $maskLength <= 32) {
                return [static::parse($m[1]), $maskLength];
            }
        }

        throw new \TypeError('IpAddr: string is not formatted like an IPv4 CIDR range');
    }


    public function broadcastAddressFromCIDR(string $str)
    {
        try {
            $cidrValue = IPv4::parseCIDR($str);
            $ipInterface = $cidrValue[0];
            $subnetMask = IPv4::subnetMaskFromPrefixLength($cidrValue[1]);
            $octets = [];
            $i = 0;
            while ($i < 4) {
                array_push($octets, intval($ipInterface->octets[$i], 10) | intval($subnetMask[$i], 10) ^ 255);
                $i++;
            }

            return new IPv4($octets);
        } catch (\Throwable $exception) {
            throw new \TypeError('IpAddr: the address does not have ipv4 CIDR format');
        }
    }


    public static function subnetMaskFromPrefixLength($prefix)
    {
        if ($prefix < 0 || $prefix > 32) {
            throw new \TypeError('IpAddr: invalid prefix length');
        }

        $octets = [0, 0, 0, 0];
        $j = 0;
        while ($j < floor($prefix / 8)) {
            $octets[$j] = 255;
            $j++;
        }

        $f_val = floor($prefix / 8);
        $p_val = pow(2, $prefix % 8);
        $octets[$f_val] = $p_val - 1 << 8 - ($prefix % 8);

        return new IPv4($octets);
    }


    public function __get($name)
    {
        if ($name === 'specialRanges') {
            $this->specialRanges();
            return $this->specialRangesArray;
        }
    }


    private function specialRanges()
    {
        $this->specialRangesArray['unspecified'] = [
            [(new IPv4([0, 0, 0, 0])), 8]
        ];
        $this->specialRangesArray['broadcast'] = [
            [(new IPv4([255, 255, 255, 255])), 32]
        ];
        $this->specialRangesArray['multicast'] = [
            [(new IPv4([224, 0, 0, 0])), 4]
        ];
        $this->specialRangesArray['linkLocal'] = [
            [(new IPv4([169, 254, 0, 0])), 16]
        ];
        $this->specialRangesArray['loopback'] = [
            [(new IPv4([127, 0, 0, 0])), 8]
        ];
        $this->specialRangesArray['carrierGradeNat'] = [
            [(new IPv4([100, 64, 0, 0])), 10]
        ];
        $this->specialRangesArray['private'] = [
            [(new IPv4([10, 0, 0, 0])), 8],
            [(new IPv4([172, 16, 0, 0,])), 12],
            [(new IPv4([192, 168, 0, 0])), 16]
        ];
        $this->specialRangesArray['reserved'] = [
            [(new IPv4([192, 0, 0, 0])), 24],
            [(new IPv4([192, 0, 2, 0])), 24],
            [(new IPv4([192, 88, 99, 0])), 24],
            [(new IPv4([198, 51, 100, 0])), 24],
            [(new IPv4([203, 0, 113, 0])), 24],
            [(new IPv4([240, 0, 0, 0])), 4]
        ];
    }
}