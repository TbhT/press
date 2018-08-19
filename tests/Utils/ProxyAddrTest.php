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


}
