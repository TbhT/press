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
        $req->headers['server']['remote_addr'] = $socketAddr;
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
}
