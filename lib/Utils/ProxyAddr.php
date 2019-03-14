<?php
declare (strict_types = 1);

namespace Press\Utils;

use Press\Request;
use Press\Utils\Forwarded;
use Press\Utils\IPAddr;


const IP_RANGES = [
    'linklocal' => ['169.254.0.0/16', 'fe80::/10'],
    'loopback' => ['127.0.0.1/8', '::1/128'],
    'uniquelocal' => ['10.0.0.0/8', '172.16.0.0/12', '192.168.0.0/16', 'fc00::/7']
];


class ProxyAddr
{

    /**
     * determine address of proxied request
     * @param Request $req
     * @param $trust
     * @return mixed
     */
    public static function proxyaddr(Request $req, $trust = null)
    {
        if (!$req) {
            throw new \TypeError('req argument is required');
        }

        if ($trust === null) {
            throw new \TypeError('trust argument is required');
        }

        $addrs = self::alladdrs($req, $trust);
        $addr = $addrs[count($addrs) - 1];

        return $addr;
    }

    public static function all(Request $req, $trust = null)
    {
        return self::alladdrs($req, $trust);
    }


    /**
     * Get all addresses in the request, optionally stopping at the first untrusted
     * @param Request $req
     * @param $trust
     * @return array
     */
    public static function alladdrs(Request $req, $trust = null)
    {
        // get all addresses
        $addrs = Forwarded::forwarded($req);

        if (!$trust && is_array($trust) === false) {
            // return all addresses
            return $addrs;
        }

        if (is_callable($trust) === false) {
            $trust = static::compile($trust);
        }

        for ($i = 0; $i < count($addrs) - 1; $i++) {
            if ($trust($addrs[$i], $i)) {
                continue;
            }

            $addrs = array_slice($addrs, 0, $i + 1);
        }

        return $addrs;
    }

    public static function compile($val)
    {
        if (!$val && is_array($val) === false) {
            throw new \TypeError('arguments is required');
        }

        if (is_string($val)) {
            $trust = [$val];
        } else if (is_array($val)) {
            $trust = array_slice($val, 0);
        } else {
            throw new \TypeError('unsupported trust argument');
        }

        for ($i = 0; $i < count($trust); $i++) {
            $val = $trust[$i];

            if (!array_key_exists($val, IP_RANGES)) {
                continue;
            }

            // splice in pre-defined range
            $val = IP_RANGES[$val];
            array_splice($trust, $i, 1, $val);
            $i += count($val) - 1;
        }

        return static::compileTrust(static::compileRangeSubnets($trust));
    }

    private static function compileTrust($rangeSubnets)
    {
        // return optimized function based on length
        $length = count($rangeSubnets);
        return $length === 0 ?
            static::trustNone() : ($length === 1 ?
                static::trustSingle($rangeSubnets[0]) : static::trustMulti($rangeSubnets));
    }

    /**
     * compile arr elements into range subnets
     * @param $arr
     * @return array
     */
    private static function compileRangeSubnets($arr)
    {
        $rangeSubnets = [];
        foreach ($arr as $value) {
            array_push($rangeSubnets, static::parseipNotation($value));
        }

        return $rangeSubnets;
    }

    private static function parseipNotation(string $note)
    {
        $pos = strpos($note, '/');
        $str = $pos !== false ? substr($note, 0, $pos) : $note;

        if (!IPAddr\Tool::isValid($str)) {
            throw new \TypeError("invalid IP address {$str}");
        }

        $ip = IPAddr\Tool::parse($str);

        if ($pos === false && $ip->kind() === 'ipv6' && $ip->isIPv4MappedAddress()) {
            // store as IPv4
            $ip = $ip->toIPv4Address();
        }

        $max = $ip->kind() === 'ipv6' ? 128 : 32;
        $range = $pos !== false ? substr($note, $pos + 1, strlen($note)) : '';
        preg_match('/^[0-9]+$/', $range, $m);

        if ($range === '') {
            $range = $max;
        } else if (count($m) > 0) {
            $range = intval($range, 10);
        } else if ($ip->kind() === 'ipv4' && IPAddr\Tool::isValid($range)) {
            $range = static::parseNetmask($range);
        } else {
            $range = '';
        }

        if ($range <= 0 || $range > $max) {
            throw new \TypeError("invalid range on address: {$note}");
        }

        return [$ip, $range];
    }

    /**
     * parse netmask string into CIDR range
     * @param $netmask
     * @return int|mixed|null
     */
    private static function parseNetmask($netmask)
    {
        $ip = IPAddr\Tool::parse($netmask);
        $kind = $ip->kind();

        return $kind === 'ipv4' ? $ip->prefixLengthFromSubnetMask() : null;
    }

    /**
     * static trust function to trust nothing
     * @return \Closure
     */
    private static function trustNone()
    {
        return function () {
            return false;
        };
    }

    /**
     * compile trust function for multiple subnets
     * @param $subnets
     * @return \Closure
     */
    private static function trustMulti($subnets)
    {
        return function ($addr) use ($subnets) {
            if (IPAddr\Tool::isValid($addr) === false) {
                return false;
            }

            $ip = IPAddr\Tool::parse($addr);
            $kind = $ip->kind();
            $ipconv = null;

            for ($i = 0; $i < count($subnets); $i++) {
                $subnet = $subnets[$i];
                $subnetip = $subnet[0];
                $subnetkind = $subnetip->kind();
                $subnetrange = $subnet[1];
                $trusted = $ip;

                if ($kind !== $subnetkind) {
                    if ($subnetkind === 'ipv4' && $ip->isIPv4MappedAddress() === false) {
                        // incompatible IP address
                        continue;
                    }

                    if (!$ipconv) {
                        // convert IP to match subnet IP kind
                        $ipconv = $subnetkind === 'ipv4' ? $ip->toIPv4Address() : $ip->toIPv4MappedAddress();
                    }

                    $trusted = $ipconv;
                }

                if ($trusted->match($subnetip, $subnetrange)) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * compile trust function for single subnet
     * @param $subnet
     * @return \Closure
     */
    private static function trustSingle($subnet)
    {
        $subnetip = $subnet[0];
        $subnetkind = $subnetip->kind();
        $subnetisipv4 = $subnetkind === 'ipv4';
        $subnetrange = $subnet[1];

        return function ($addr) use ($subnetisipv4, $subnetkind, $subnetrange, $subnetip) {
            if (IPAddr\Tool::isValid($addr) === false) {
                return false;
            }

            $ip = IPAddr\Tool::parse($addr);
            $kind = $ip->kind();

            if ($kind !== $subnetkind) {
                if ($subnetisipv4 && !$ip->isIPv4MappedAddress()) {
                    // incompatible ip address
                    return false;
                }

                // convert ip to match subnet ip kind
                $ip = $subnetisipv4 ? $ip->toIPv4Address() : $ip->toIPv4MappedAddress();
            }

            return $ip->match($subnetip, $subnetrange);
        };
    }
}

