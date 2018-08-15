<?php
/**
 * Created by PhpStorm.
 * User: 88002
 * Date: 2018-08-07
 * Time: 20:14
 */

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
     * Get all addresses in the request, optionally stopping at the first untrusted
     * @param Request $req
     * @param $trust
     */
    public static function alladdrs(Request $req, $trust)
    {
        // get all addresses
        $addrs = Forwarded::forwarded($req);

        if (!$trust) {
            // return all addresses
            return $addrs;
        }

        if (is_callable($trust) === false) {
            $trust = static::compile();
        }
    }

    public static function compile($val)
    {
        if (!$val) {
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

            if (!IP_RANGES[$val]) {
                continue;
            }

            // splice in pre-defined range
            $val = IP_RANGES[$val];
            array_splice($trust, $i, 1, $val);
            $i += count($val) -1;
        }

        return static::compileTrust(static::compileRangeSubnets($trust));
    }

    public static function compileTrust($rangeSubnets)
    {
        // return optimized function based on length

    }

    public static function compileRangeSubnets()
    {

    }

    /**
     * compile trust function for single subnet
     * @param $subnet
     */
    private static function trustSingle($subnet)
    {
        $subnetip = $subnet[0];
        $subnetkind = $subnetip->kind();
        $subnetisipv4 = $subnetkind === 'ipv4';
        $subnetrange = $subnet[1];

        return function ($addr) {
            if (IPAddr\Tool::isValid($addr) === false) {
                // incompatible ip address
                return false;
            }

            // convert ip to match subnet ip kind 
        };
    }
}