<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-8-12
 * Time: 下午4:49
 */

use Press\Utils\IPAddr;
use Press\Utils\IPAddr\IPv4;
use Press\Utils\IPAddr\IPv6;
use PHPUnit\Framework\TestCase;


class IpAddrTest extends TestCase
{
    public function testNotThrowError()
    {
        new IPAddr\IPv4([192, 168, 1, 2]);
        self::assertTrue(true);
    }

    public function invalidIPv4()
    {
        return [
            [300, 1, 2, 3],
            [8, 8, 8]
        ];
    }

    /**
     * @dataProvider invalidIPv4
     * @expectedException TypeError
     */
    public function testShouldThrow($d)
    {
        new IPAddr\IPv4($d);
    }

    public function testConvertIPv4ToString()
    {
        $addr = new IPAddr\IPv4([192, 168, 1, 1]);
        self::assertEquals($addr->toString(), '192.168.1.1');
    }

    public function testReturnCorrectKindForIPv4()
    {
        $addr = new IPAddr\IPv4([1, 2, 3, 4]);
        self::assertEquals($addr->kind(), 'ipv4');
    }

    public function testAccessIPv4Octets()
    {
        $addr = new IPAddr\IPv4([42, 0, 0, 0]);
        self::assertEquals($addr->octets[0], 42);
    }

    public function testCheckIPv4AddressFormat()
    {
        self::assertEquals(true, IPAddr\IPv4::isIPv4('192.168.007.0xa'));
        self::assertEquals(true, IPAddr\IPv4::isIPv4('1024.0.0.1'));
        self::assertEquals(false, IPAddr\IPv4::isIPv4('8.0xa.wtf.6'));
    }

    public function testValidatesIPv4Address()
    {
        self::assertEquals(true, IPAddr\IPv4::isValid('192.168.007.0xa'));
        self::assertEquals(false, IPAddr\IPv4::isValid('1024.0.0.1'));
        self::assertEquals(false, IPAddr\IPv4::isValid('8.0xa.wtf.6'));
    }

    public function testParsesIPv4InServeralWeirdFormats()
    {
        self::assertEquals([192, 168, 1, 1], IPAddr\IPv4::parse('192.168.1.1')->octets);
        self::assertEquals([192, 168, 1, 1], IPAddr\IPv4::parse('0xc0.168.1.1')->octets);
        self::assertEquals([192, 168, 1, 1], IPAddr\IPv4::parse('192.0250.1.1')->octets);
        self::assertEquals([192, 168, 1, 1], IPAddr\IPv4::parse('0xc0a80101')->octets);
        self::assertEquals([192, 168, 1, 1], IPAddr\IPv4::parse('030052000401')->octets);
        self::assertEquals([192, 168, 1, 1], IPAddr\IPv4::parse('3232235777')->octets);
    }

    /**
     * @expectedException TypeError
     */
    public function testBarfsInvalidIPv4()
    {
        IPAddr\IPv4::parse('10.0.0.wtf');
    }

    public function testMatchIPv4CIDRCorrect()
    {
        $addr = new IPv4([10, 5, 0, 1]);
        self::assertEquals(true, $addr->match(IPv4::parse('0.0.0.0'), 0));
        self::assertEquals(false, $addr->match(IPv4::parse('11.0.0.0'), 8));
        self::assertEquals(true, $addr->match(IPv4::parse('10.0.0.0'),8));
        self::assertEquals(true, $addr->match(IPv4::parse('10.0.0.1'), 8));
        self::assertEquals(true, $addr->match(IPv4::parse('10.0.0.10'), 8));
        self::assertEquals(true, $addr->match(IPv4::parse('10.5.5.0'), 16));
        self::assertEquals(false, $addr->match(IPv4::parse('10.4.5.0'), 16));
        self::assertEquals(true, $addr->match(IPv4::parse('10.4.5.0'), 15));
        self::assertEquals(false, $addr->match(IPv4::parse('10.5.0.2'), 32));
        self::assertEquals(true, $addr->match($addr, 32));
    }

    public function testParsesIPv4CIDRCorrect()
    {
        $addr = new IPv4([10, 5, 0, 1]);
        self::assertEquals(true, $addr->match(IPv4::parseCIDR('0.0.0.0/0')));
        self::assertEquals(false, $addr->match(IPv4::parseCIDR('11.0.0.0/8')));
        self::assertEquals(true, $addr->match(IPv4::parseCIDR('10.0.0.0/8')));
        self::assertEquals(true, $addr->match(IPv4::parseCIDR('10.0.0.1/8')));
        self::assertEquals(true, $addr->match(IPv4::parseCIDR('10.0.0.10/8')));
        self::assertEquals(true, $addr->match(IPv4::parseCIDR('10.5.5.0/16')));
        self::assertEquals(false, $addr->match(IPv4::parseCIDR('10.4.5.0/16')));
        self::assertEquals(true, $addr->match(IPv4::parseCIDR('10.4.5.0/15')));
        self::assertEquals(false, $addr->match(IPv4::parseCIDR('10.5.0.2/32')));
        self::assertEquals(true, $addr->match(IPv4::parseCIDR('10.5.0.1/32')));
    }

    public function parsesIPv4CIDRExceptionData()
    {
        return [
            ['10.5.0.1'],
            ['0.0.0.0/-1'],
            ['0.0.0.0/33']
        ];
    }

    /**
     * @expectedException TypeError
     */
    public function testParsesIPv4CIDRException($cidr)
    {
        IPv4::parseCIDR($cidr);
    }

    public function reservedIPv4NetworksData()
    {
        return [
            ['0.0.0.0', 'unspecified'],
            ['0.1.0.0', 'unspecified'],
            ['10.1.0.1', 'private'],
            ['100.64.0.0', 'carrierGradeNat'],
            ['100.127.255.255', 'carrierGradeNat'],
            ['192.168.2.1', 'private'],
            ['224.100.0.1', 'multicast'],
            ['169.254.15.0', 'linkLocal'],
            ['127.1.1.1', 'loopback'],
            ['255.255.255.255', 'broadcast'],
            ['240.1.2.3', 'reserved'],
            ['8.8.8.8', 'unicast']
        ];
    }

    /**
     * @dataProvider reservedIPv4NetworksData
     */
    public function testReservedIPv4Networks($ip, $range)
    {
        self::assertEquals(IPv4::parse($ip)->range(), $range);
    }
}
