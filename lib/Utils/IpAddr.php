<?php
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-8-8
 * Time: 下午11:21
 */

namespace Press\Utils;


class IpAddr
{
    public function matchCIDR() {

    }
}


class IPv4
{
    public $octets;

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

    }
}


class IPv6
{

}