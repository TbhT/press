<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-8-8
 * Time: 下午11:21
 */

namespace Press\Utils\IPAddr;


class Tool
{
    public static function isValid(string $str)
    {
        return IPv6::isValid($str) || IPv4::isValid($str);
    }


    public static function parse(string $str)
    {
        if (IPv6::isValid($str)) {
            return IPv6::parse($str);
        } else if (IPv4::isValid($str)) {
            return IPv4::parse($str);
        } else {
            throw new \TypeError('IpAddr: the address has neither IPv6 nor IPv4 format');
        }
    }


    public static function parseCIDR(string $str)
    {
        try {
            return IPv6::parseCIDR($str);
        } catch (\Throwable $e1) {
            try {
                return IPv4::parseCIDR($str);
            } catch (\Throwable $e2) {
                throw new \TypeError('IpAddr: the address has neither IPv6 nor IPv4 CIDR format');
            }
        }
    }


    public static function fromByteArray($bytes)
    {
        $length = count($bytes);
        if ($length === 4) {
            return new IPv4($bytes);
        } else if ($length === 16) {
            return new IPv6($bytes);
        } else {
            throw new \TypeError('IpAddr: the binary input is neither an IPv6 nor IPv4 address');
        }
    }


    public static function process(string $str)
    {
        $addr = static::parse($str);
        if ($addr->kind() === 'ipv6' && $addr->isIPv4MappedAddress()) {
            return $addr->toIPv4Address();
        } else {
            return $addr;
        }
    }

    public static function matchCIDR(array $first, array $second, $partSize, $cidrBits)
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


    public static function subnetMatch($address, array $rangeList, $defaultName = 'unicast')
    {
        foreach ($rangeList as $rangeName => $rangeSubnets) {
            if ($rangeSubnets && $rangeSubnets[0] && is_array($rangeSubnets[0]) === false) {
                $rangeSubnets = [$rangeSubnets];
            }

            foreach ($rangeSubnets as $rangeSubnet) {
                if ($address->match($rangeSubnet)) {
                    return $rangeName;
                }
            }
        }

        return $defaultName;
    }


    public static function expandIPv6(string $string, $parts)
    {
        if (strpos($string, '::') !== stripos($string, '::')) {
            return null;
        }

        $colonCount = 0;
        $lastColon = -1;

        while (($lastColon = strpos($string, ':', $lastColon + 1)) !== false) {
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
        $replacement = ':';

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

}