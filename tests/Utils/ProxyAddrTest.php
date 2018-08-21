<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-8-16
 * Time: 下午11:10
 */

use Press\Utils\ProxyAddr;
use Press\Request;
use PHPUnit\Framework\TestCase;


class ProxyAddrTest extends TestCase
{
    private function all()
    {
        return function () {
            return true;
        };
    }

    private function none()
    {
        return function () {
            return false;
        };
    }

    private function trust10x()
    {
        return function ($addr) {
            preg_match('/^10\./', $addr, $m);
            return count($m) > 0;
        };
    }

    private function createReq($socketAddr, $headers = null)
    {
        $req = new Request();
        $req->headers = empty($headers) ? [] : $headers;
        $req->server['remote_addr'] = $socketAddr;
        return $req;
    }

    /**
     * @expectedException TypeError
     */
    public function testArguments()
    {
        ProxyAddr::proxyaddr();
    }

    /**
     * @expectedException TypeError
     */
    public function testTrustRequired()
    {
        $req = self::createReq('127.0.0.1');
        ProxyAddr::proxyaddr($req);
    }

    public function trustRequiredDiffArgument()
    {
        return [
            [self::all()],
            [[]],
            ['127.0.0.1'],
            ['::1'],
            ['::ffff:127.0.0.1'],
            ['loopback'],
            [['loopback', '10.0.0.1']]
        ];
    }

    /**
     * @dataProvider trustRequiredDiffArgument
     */
    public function testTrustRequiredDiffArgument($r)
    {
        $req = self::createReq('127.0.0.1');
        ProxyAddr::proxyaddr($req, $r);
        self::assertTrue(true);
    }

    /**
     * @expectedException TypeError
     */
    public function testTrustRejectedWithNumber()
    {
        $req = self::createReq('127.0.0.1');
        ProxyAddr::proxyaddr($req, 42);
    }

    public function testNotAlterInputArray()
    {
        $arr = ['loopback', '10.0.0.1'];
        $req = self::createReq('127.0.0.1');
        ProxyAddr::proxyaddr($req, $arr);
        self::assertEquals(['loopback', '10.0.0.1'], $arr);
    }

    public function rejectNonIpData()
    {
        return [
            ['brargh'],
            ['10.0.300.1'],
            ['::ffff:30.168.1.9000'],
            ['-1']
        ];
    }

    /**
     * @dataProvider rejectNonIpData
     * @expectedException TypeError
     */
    public function testRejectNonIpData($addr)
    {
        $req = self::createReq('127.0.0.1');
        ProxyAddr::proxyaddr($req, $addr);
    }

    public function rejectBadCIDR()
    {
        return [
            ['10.0.0.1/internet'],
            ['10.0.0.1/6000'],
            ['::1/6000'],
            ['::ffff:a00:2/136'],
            ['::ffff:a00:2/-1']
        ];
    }

    /**
     * @expectedException TypeError
     * @dataProvider rejectBadCIDR
     */
    public function testRejectBadCIDR($addr)
    {
        $req = self::createReq('127.0.0.1');
        ProxyAddr::proxyaddr($req, $addr);
    }

    public function rejectBadNetmask()
    {
        return [
            ['10.0.0.1/255.0.255.0'],
            ['10.0.0.1/ffc0::'],
            ['fe80::/ffc0::'],
            ['fe80::/255.255.255.0'],
            ['::ffff:a00:2/255.255.255.0']
        ];
    }

    /**
     * @expectedException TypeError
     * @dataProvider rejectBadNetmask
     */
    public function testRejectBadNetmask($addr)
    {
        $req = self::createReq('127.0.0.1');
        ProxyAddr::proxyaddr($req, $addr);
    }

    public function testInvokedAsTrust()
    {
        $log = [];
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.1']);

        ProxyAddr::proxyaddr($req, function ($addr, $i) use (& $log) {
            return array_push($log, [$addr, $i]);
        });

        self::assertEquals([
            ['127.0.0.1', 0],
            ['10.0.0.1', 1]
        ], $log);
    }

    // all trust

    public function testReturnSocketAddressWithNoheadersWithTrustAll()
    {
        $req = self::createReq('127.0.0.1');
        self::assertEquals('127.0.0.1', ProxyAddr::proxyaddr($req, self::all()));
    }

    public function testReturnHeaderValueWithTrustAll()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => '10.0.0.1']);
        self::assertEquals('10.0.0.1', ProxyAddr::proxyaddr($req, self::all()));
    }

    public function testFurtherHeaderValueTrustAll()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => '10.0.0.1, 10.0.0.2']);
        self::assertEquals('10.0.0.1', ProxyAddr::proxyaddr($req, self::all()));
    }

    // none trust

    public function testReturnSocketAddressWithNoHeadersWithNoneTrust()
    {
        $req = self::createReq('127.0.0.1');
        self::assertEquals('127.0.0.1', ProxyAddr::proxyaddr($req, self::none()));
    }

    public function testReturnSocketAddressWithHeadersWithNoneTrust()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => '10.0.0.1, 10.0.0.2']);
        self::assertEquals('127.0.0.1', ProxyAddr::proxyaddr($req, self::none()));
    }

    //  some trust
    public function testReturnSocketAddressWithNoHeadersWithSomeTrust()
    {
        $req = self::createReq('127.0.0.1');
        self::assertEquals('127.0.0.1', ProxyAddr::proxyaddr($req, self::trust10x()));
    }

    public function testReturnSocketAddressWithNotTrustedWithSomeTrust()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => '10.0.0.1, 10.0.0.2']);
        self::assertEquals('127.0.0.1', ProxyAddr::proxyaddr($req, self::trust10x()));
    }

    public function testReturnHeaderWhenSocketTrusted()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1']);
        self::assertEquals('192.168.0.1', ProxyAddr::proxyaddr($req, self::trust10x()));
    }

    public function testReturnFirstUntrustedAfterTrusted()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.2']);
        self::assertEquals('192.168.0.1', ProxyAddr::proxyaddr($req, self::trust10x()));
    }

    // why it should not skip untrusted
    public function testNotSkipUntrusted()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '10.0.0.3, 192.168.0.1, 10.0.0.2']);
        self::assertEquals('192.168.0.1', ProxyAddr::proxyaddr($req, self::trust10x()));
    }

    // when given array
    public function testShouldAcceptLiteralIPAddress()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.2']);
        self::assertEquals('192.168.0.1', ProxyAddr::proxyaddr($req, ['10.0.0.1', '10.0.0.2']));
    }

    public function testShouldNotTrustNonIPAddress()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.2, localhost']);
        self::assertEquals('localhost', ProxyAddr::proxyaddr($req, ['10.0.0.1', '10.0.0.2']));
    }

    public function testShouldReturnSocketAddressIfNoneMatch()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.2']);
        self::assertEquals('10.0.0.1', ProxyAddr::proxyaddr($req, ['127.0.0.1', '192.168.0.100']));
    }

    // when array empty
    public function testShouldReturnSocketAddress()
    {
        $req = self::createReq('127.0.0.1');
        self::assertEquals('127.0.0.1', ProxyAddr::proxyaddr($req, []));
    }

    public function testShouldReturnSocketAddressWithHeaders()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => '10.0.0.1, 10.0.0.2']);
        self::assertEquals('127.0.0.1', ProxyAddr::proxyaddr($req, []));
    }

    // when given ipv4 addresses
    public function testAcceptLiteralIPAddressWhenIPv4()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.2']);
        self::assertEquals('192.168.0.1', ProxyAddr::proxyaddr($req, ['10.0.0.1', '10.0.0.2']));
    }

    public function testAcceptCIDRNotationWhenIPv4()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.200']);
        self::assertEquals('10.0.0.200', ProxyAddr::proxyaddr($req, '10.0.0.2/26'));
    }

    public function testAcceptNetmaskNotation()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.200']);
        self::assertEquals('10.0.0.200', ProxyAddr::proxyaddr($req, '10.0.0.2/255.255.255.192'));
    }

    // when given ipv6 address
    public function testAcceptLiteralIPAddressWhenIPv6()
    {
        $req = self::createReq('fe80::1', ['x-forwarded-for' => '2002:c000:203::1, fe80::2']);
        self::assertEquals('2002:c000:203::1', ProxyAddr::proxyaddr($req, 'fe80::/125'));
    }

    public function testAcceptCIDRNotationWhenIPv6()
    {
        $req = self::createReq('fe80::1', ['x-forwarded-for' => '2002:c000:203::1, fe80::ff00']);
        self::assertEquals('fe80::ff00', ProxyAddr::proxyaddr($req, 'fe80::/125'));
    }

    // when IP versions mixed
    public function testMatchRespectiveVersions()
    {
        $req = self::createReq('::1', ['x-forwarded-for' => '2002:c000:203::1']);
        self::assertEquals('2002:c000:203::1', ProxyAddr::proxyaddr($req, ['127.0.0.1', '::1']));
    }

    public function testNotMatchIPv4ToIPv6()
    {
        $req = self::createReq('::1', ['x-forwarded-for' => '2002:c000:203::1']);
        self::assertEquals('::1', ProxyAddr::proxyaddr($req, '127.0.0.1'));
    }


    // when ipv4-mapped ipv6 addresses
    public function testMatchIPv4TrustToIPv6Request()
    {
        $req = self::createReq('::ffff:a00:1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.2']);
        self::assertEquals('192.168.0.1', ProxyAddr::proxyaddr($req, ['10.0.0.1/16']));
    }

    public function testMatchIPv6TrustToIPv4Request()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.2']);
        self::assertEquals('192.168.0.1', ProxyAddr::proxyaddr($req, ['::ffff:a00:1', '::ffff:a00:2']));
    }

    public function testMatchCIDRNotationForIPv4MappedAddress()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.200']);
        self::assertEquals('10.0.0.200', ProxyAddr::proxyaddr($req, '::ffff:a00:2/122'));
    }

    public function testMatchCIDRNotationForIPv4MappedAddressMixedWithIPv6CIDR()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.200']);
        self::assertEquals('10.0.0.200', ProxyAddr::proxyaddr($req, ['::ffff:a00:2/122', 'fe80::/125']));
    }

    public function testMatchCIDRNotationFOrIPv4MappedAddressMixedWithIPv4Address()
    {
        $req = self::createReq('10.0.0.1', ['x-forwarded-for' => '192.168.0.1, 10.0.0.200']);
        self::assertEquals('10.0.0.200', ProxyAddr::proxyaddr($req, ['::ffff:a00:2/122', '127.0.0.1']));
    }

    // when given pre-defined names
    public function testAcceptSinglePredefinedName()
    {
        $req = self::createReq('fe80::1', ['x-forwarded-for' => '2002:c000:203::1, fe80::2']);
        self::assertEquals('2002:c000:203::1', ProxyAddr::proxyaddr($req, 'linklocal'));
    }

    public function testAcceptMultiplePredefinedNames()
    {
        $req = self::createReq('::1', ['x-forwarded-for' => '2002:c000:203::1, fe80::2']);
        self::assertEquals('2002:c000:203::1', ProxyAddr::proxyaddr($req, ['loopback', 'linklocal']));
    }

    // when header contains non0ip addresses
    public function testStopAtFirstNonIPAfterTrusted()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => 'myrouter, 127.0.0.1, proxy']);
        self::assertEquals('proxy', ProxyAddr::proxyaddr($req, '127.0.0.1'));
    }

    public function testSopAtFirstMalformedIpAfterTrusted()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => 'myrouter, 127.0.0.1, ::8:8:8:8:8:8:8:8:8']);
        self::assertEquals('::8:8:8:8:8:8:8:8:8', ProxyAddr::proxyaddr($req, '127.0.0.1'));
    }

    public function testProvideAllValuesToFunction()
    {
        $log = [];
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => 'myrouter, 127.0.0.1, proxy']);

        ProxyAddr::proxyaddr($req, function ($addr, $i) use (& $log) {
            return array_push($log, [$addr, $i]);
        });

        self::assertEquals([
            ['127.0.0.1', 0],
            ['proxy', 1],
            ['127.0.0.1', 2]
        ], $log);
    }

    // when socket address null
    public function testReturnNullAsAddress()
    {
        $req = self::createReq(null);
        self::assertEquals(null, ProxyAddr::proxyaddr($req, '127.0.0.1'));
    }

    public function testReturnNullEvenWithTrustedHeaders()
    {
        $req = self::createReq(null, ['x-forwarded-for' => '127.0.0.1, 10.0.0.1']);
        self::assertEquals(null, ProxyAddr::proxyaddr($req, '127.0.0.1'));
    }

    // proxyaddr.all

    /**
     * @expectedException TypeError
     */
    public function testArgumentsShouldBeRequired()
    {
        ProxyAddr::all();
    }

    public function testArgumentsShouldBeOptional()
    {
        $req = self::createReq('127.0.0.1');
        ProxyAddr::all($req);
        self::assertTrue(true);
    }

    public function testWithNoHeaders()
    {
        $req = self::createReq('127.0.0.1');
        self::assertEquals(['127.0.0.1'], ProxyAddr::all($req));
    }

    public function testShouldIncludeXForwardedForHeader()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => '10.0.0.1']);
        self::assertEquals(['127.0.0.1', '10.0.0.1'], ProxyAddr::all($req));
    }

    public function testShouldIncludeXForWardedForInCorrectOrder()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => '10.0.0.1, 10.0.0.2']);
        self::assertEquals(['127.0.0.1', '10.0.0.2', '10.0.0.1'], ProxyAddr::all($req));
    }

    public function testShouldStopAtFirstUntrusted()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => '10.0.0.1, 10.0.0.2']);
        self::assertEquals(['127.0.0.1', '10.0.0.2'], ProxyAddr::all($req, '127.0.0.1'));
    }

    public function testShouldBeOnlySocketAddressForNoTrust()
    {
        $req = self::createReq('127.0.0.1', ['x-forwarded-for' => '10.0.0.1, 10.0.0.2']);
        self::assertEquals(['127.0.0.1'], ProxyAddr::all($req, []));
    }

    // proxyaddr.compile

    /**
     * @expectedException TypeError
     */
    public function testArgumentsShouldBeRequiredInCompile()
    {
        ProxyAddr::compile();
    }


    public function testArgumentsShouldAccept()
    {
        self::assertTrue(is_callable(ProxyAddr::compile([])));
        self::assertTrue(is_callable(ProxyAddr::compile('127.0.0.1')));
        self::assertTrue(is_callable(ProxyAddr::compile('::1')));
        self::assertTrue(is_callable(ProxyAddr::compile('::ffff:127.0.0.1')));
        self::assertTrue(is_callable(ProxyAddr::compile('loopback')));
        self::assertTrue(is_callable(ProxyAddr::compile(['loopback', '10.0.0.1'])));
    }

    /**
     * @expectedException TypeError
     */
    public function testArgumentsShouldRejectNumber()
    {
        ProxyAddr::compile(42);
    }

    /**
     * @expectedException TypeError
     */
    public function testArgumentsShouldRejectNonIP()
    {
        ProxyAddr::compile('blargh');
    }

    /**
     * @expectedException TypeError
     */
    public function testArgumentsShouldBeRejectNonIP2()
    {
        ProxyAddr::compile(ProxyAddr::compile('-1'));
    }

    /**
     * @expectedException TypeError
     */
    public function testArgumentsShouldBeRejectedBadCIDR1()
    {
        ProxyAddr::compile('10.0.0.1/6000');
    }

    /**
     * @expectedException TypeError
     */
    public function testArgumentsShouldBeRejectedBadCIDR2()
    {
        ProxyAddr::compile('::1/6000');
    }

    /**
     * @expectedException TypeError
     */
    public function testArgumentsShouldBeRejectedBadCIDR3()
    {
        ProxyAddr::compile('::ffff:a00:2/136');
    }

    /**
     * @expectedException TypeError
     */
    public function testArgumentsShouldBeRejectedBadCIDR4()
    {
        ProxyAddr::compile('::ffff:a00:2/-46');
    }

    public function testShouldNotAlterInputArray()
    {
        $arr = ['loopback', '10.0.0.1'];
        self::assertTrue(is_callable(ProxyAddr::compile($arr)));
        self::assertEquals(['loopback', '10.0.0.1'], $arr);
    }
}
