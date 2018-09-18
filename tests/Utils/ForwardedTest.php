<?php
declare(strict_types=1);

use Press\Utils\Forwarded;
use Press\Request;
use PHPUnit\Framework\TestCase;


class ForwardedTest extends TestCase
{
    private function createReq($socket_addr, $headers = [])
    {
        if (count($headers) === 0) {
            $headers = [];
        }

        $req = new Request();
        $req->server['remote_addr'] = $socket_addr;
        $req->headers = $headers;

        return $req;
    }


    /**
     * @expectedException TypeError
     */
    public function testWithoutReq()
    {
        Forwarded::forwarded();
    }


    public function testWithXHeader()
    {
        $req = self::createReq('127.0.0.1');
        self::assertEquals(['127.0.0.1'], Forwarded::forwarded($req));
    }


    public function testShouldIncludeEntriesFromXHeader()
    {
        $req = self::createReq('127.0.0.1', [
            'x-forwarded-for' => '10.0.0.2, 10.0.0.1'
        ]);

        self::assertEquals(['127.0.0.1', '10.0.0.1', '10.0.0.2'], Forwarded::forwarded($req));
    }


    public function testShouldSkipBlankEntries()
    {
        $req = self::createReq('127.0.0.1', [
            'x-forwarded-for' => '10.0.0.2,,10.0.0.1'
        ]);

        self::assertEquals(['127.0.0.1', '10.0.0.1', '10.0.0.2'], Forwarded::forwarded($req));
    }


    public function testShouldTrimLeadingOWS()
    {
        $req = self::createReq('127.0.0.1', [
            'x-forwarded-for' => '10.0.0.2, ,10.0.0.1'
        ]);

        self::assertEquals(['127.0.0.1', '10.0.0.1', '10.0.0.2'], Forwarded::forwarded($req));
    }

}