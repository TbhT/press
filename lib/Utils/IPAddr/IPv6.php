<?php
declare(strict_types=1);

namespace Press\Utils\IPAddr;


const IPV6_NATIVE = '/^(::)?((?:[0-9a-f]+::?)+)?([0-9a-f]+)?(::)?$/i';

const IPV6_TRANSITIONAL = '/^((?:(?:[0-9a-f]+::?)+)|(?:::)(?:(?:[0-9a-f]+::?)+)?)(0?\\d+|0x[a-f0-9]+)\\.(0?\\d+|0x[a-f0-9]+)\\.(0?\\d+|0x[a-f0-9]+)\\.(0?\\d+|0x[a-f0-9]+)$/i';


class IPv6
{
    public $parts;
    private $specialRangesArray = [
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
        'reserved' => []
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
    }


    public function kind()
    {
        return 'ipv6';
    }


    public function toString()
    {
        $stringParts = [];
        foreach ($this->parts as $part) {
            array_push($stringParts, dechex(intval($part, 16)));
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
        }

        if ($state === 2) {
            array_push($compactStringParts, '');
            array_push($compactStringParts, '');
        }

        return join($compactStringParts, ':');
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
            array_push($parts_, dechex(intval($value, 16)));
        }

        return join($parts_, ':');
    }


    public function match($other, $cidrRange = null)
    {
        if ($cidrRange === null) {
            $cidrRange = $other[1];
            $other = $other[0];
        }

        if ($other->kind() !== 'ipv6') {
            throw new \TypeError('IpAddr: cannot match ipv6 address with non-ipv6 one');
        }

        return Tool::matchCIDR($this->parts, $other->parts, 16, $cidrRange);
    }


    public function range()
    {
        return Tool::subnetMatch($this, $this->specialRanges);
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
        $high = intval($ref[0], 16);
        $low = intval($ref[1], 16);

        return new IPv4([$high >> 8, $high & 0xff, $low >> 8, $low & 0xff]);
    }


    public static function parser(string $string)
    {
        preg_match(IPV6_NATIVE, $string, $m1);
        preg_match(IPV6_TRANSITIONAL, $string, $m2);

        if (count($m1) > 0) {
            return Tool::expandIPv6($string, 8);
        } else if (count($m2) > 0) {
            $parts = Tool::expandIPv6(substr($m2[1], 0, -1), 6);
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


    public static function isIPv6(string $string)
    {
        return static::parser($string) !== null;
    }


    public static function isValid($string)
    {
        if (is_string($string) && strpos($string, ':') === false) {
            return false;
        }

        try {
            new IPv6(static::parser($string));
            return true;
        } catch (\Throwable $exception) {
            return false;
        }
    }


    public static function parseCIDR(string $string)
    {
        preg_match('/^(.+)\/(\d+)$/', $string, $m);
        if (count($m) > 0) {
            $maskLength = intval($m[2]);
            if ($maskLength >= 0 && $maskLength <= 128) {
                return [static::parse($m[1]), $maskLength];
            }
        }

        throw new \TypeError('IpAddr: string is not formatted like an IPv6 CIDR range');
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
        $this->specialRangesArray['uniqueLocal'] = [
            new IPv6([0, 0, 0, 0, 0, 0, 0, 0]), 128
        ];
        $this->specialRangesArray['linkLocal'] = [
            new IPv6([0xfe80, 0, 0, 0, 0, 0, 0, 0]), 10
        ];
        $this->specialRangesArray['multicast'] = [
            new IPv6([0xff00, 0, 0, 0, 0, 0, 0, 0]), 8
        ];
        $this->specialRangesArray['loopback'] = [
            new IPv6([0, 0, 0, 0, 0, 0, 0, 1]), 128
        ];
        $this->specialRangesArray['uniqueLocal'] = [
            new IPv6([0xfc00, 0, 0, 0, 0, 0, 0, 0]), 7
        ];
        $this->specialRangesArray['ipv4Mapped'] = [
            new IPv6([0, 0, 0, 0, 0, 0xffff, 0, 0]), 96
        ];
        $this->specialRangesArray['rfc6145'] = [
            new IPv6([0, 0, 0, 0, 0xffff, 0, 0, 0]), 96
        ];
        $this->specialRangesArray['rfc6052'] = [
            new IPv6([0x64, 0xff9b, 0, 0, 0, 0, 0, 0]), 96
        ];
        $this->specialRangesArray['6to4'] = [
            new IPv6([0x2002, 0, 0, 0, 0, 0, 0, 0]), 16
        ];
        $this->specialRangesArray['teredo'] = [
            new IPv6([0x2001, 0, 0, 0, 0, 0, 0, 0]), 32
        ];
        $this->specialRangesArray['reserved'] = [
            [new IPv6([0x2001, 0xdb8, 0, 0, 0, 0, 0, 0]), 32]
        ];
    }
}