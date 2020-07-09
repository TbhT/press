<?php

namespace Press\Tests\Utils;

use stdClass;
use function Press\Utils\fresh;
use PHPUnit\Framework\TestCase;


class Test extends TestCase
{

    public function testFreshWhenNonConditionalGet()
    {
        $req = new stdClass();
        $res = new stdClass();
        $req->header = [];
        $res->header = [];

        self::assertEquals(false, fresh($req->header, $res->header));
    }


    /**
     * $request_headers   $response_headers  $expected
     * @return array
     */
    public function ifNoneMatchData()
    {
        return [
            [
                ['if-none-match' => '"foo"'],
                ['etag' => '"foo"'],
                true
            ],
            [
                ['if-none-match' => '"foo"'],
                ['etag' => '"bar"'],
                false
            ],
            [
                ['if-none-match' => '"bar", "foo"'],
                ['etag' => '"foo"'],
                true
            ],
            [
                ['if-none-match' => '"foo"'],
                [],
                false
            ],
            [
                ['if-none-match' => 'W/"foo"'],
                ['etag' => 'W/"foo"'],
                true
            ],
            [
                ['if-none-match' => 'W/"foo"'],
                ['etag' => '"foo"'],
                true
            ],
            [
                ['if-none-match' => '"foo"'],
                ['etag' => '"foo"'],
                true
            ],
            [
                ['if-none-match' => '"foo"'],
                ['etag' => 'W/"foo"'],
                true
            ],
            [
                ['if-none-match' => '*'],
                ['etag' => '"foo"'],
                true
            ],
            [
                ['if-none-match' => '*, "bar"'],
                ['etag' => '"foo"'],
                false
            ]
        ];
    }

    /**
     * @dataProvider ifNoneMatchData
     * @param $req_headers
     * @param $res_headers
     * @param $expected
     */
    public function testIfNoneMatch($req_headers, $res_headers, $expected)
    {
        self::assertEquals($expected, fresh($req_headers, $res_headers));
    }

    /**
     * $req_headers, $res_headers, $expected
     * @return array
     */
    public function ifModifiedSince()
    {
        return [
            [
                ['if-modified-since' => 'Sat, 01 Jan 2000 00:00:00 GMT'],
                ['last-modified' => 'Sat, 01 Jan 2000 01:00:00 GMT'],
                false
            ],
            [
                ['if-modified-since' => 'Sat, 01 Jan 2000 01:00:00 GMT'],
                ['last-modified' => 'Sat, 01 Jan 2000 00:00:00 GMT'],
                true
            ],
            [
                ['if-modified-since' => 'Sat, 01 Jan 2000 00:00:00 GMT'],
                [],
                false
            ],
            [
                ['if-modified-since' => 'foo'],
                ['last-modified' => 'Sat, 01 Jan 2000 00:00:00 GMT'],
                false
            ],
            [
                ['if-modified-since' => 'Sat, 01 Jan 2000 00:00:00 GMT'],
                ['last-modified' => 'foo'],
                false
            ]
        ];
    }

    /**
     * @dataProvider ifModifiedSince
     * @param $req_header
     * @param $res_header
     * @param $expected
     * @return void
     */
    public function testIfModifiedSince($req_header, $res_header, $expected)
    {
        self::assertEquals($expected, fresh($req_header, $res_header));
    }


    public function bothData()
    {
        return [
            [
                ['if-none-match' => '"foo"', 'if-modified-since' => 'Sat, 01 Jan 2000 01:00:00 GMT'],
                ['etag' => '"foo"', 'last-modified' => 'Sat, 01 Jan 2000 00:00:00 GMT'],
                true
            ],
            [
                ['if-none-match' => '"foo"', 'if-modified-since' => 'Sat, 01 Jan 2000 00:00:00 GMT'],
                ['etag' => '"foo"', 'last-modified' => 'Sat, 01 Jan 2000 01:00:00 GMT'],
                false
            ],
            [
                ['if-none-match' => '"foo"', 'if-modified-since' => 'Sat, 01 Jan 2000 01:00:00 GMT'],
                ['etag' => '"bar"', 'last-modified' => 'Sat, 01 Jan 2000 00:00:00 GMT'],
                false
            ],
            [
                ['if-none-match' => '"foo"', 'if-modified-since' => 'Sat, 01 Jan 2000 00:00:00 GMT'],
                ['etag' => '"bar"', 'last-modified' => 'Sat, 01 Jan 2000 01:00:00 GMT'],
                false
            ]
        ];
    }


    /**
     * @dataProvider bothData
     * @param $req_headers
     * @param $res_headers
     * @param $expected
     */
    public function testIfModifiedSinceAndIfNoneMatch($req_headers, $res_headers, $expected)
    {
        self::assertEquals($expected, fresh($req_headers, $res_headers));
    }


    public function cacheControlData()
    {
        return [
            [
                ['cache-control' => 'no-cache'],
                [],
                false
            ],
            [
                ['cache-control' => ' no-cache', 'if-none-match' => '"foo"'],
                ['etag' => '"foo"'],
                false
            ],
            [
                ['cache-control' => ' no-cache', 'if-modified-since' => 'Sat, 01 Jan 2000 01:00:00 GMT'],
                ['last-modified' => 'Sat, 01 Jan 2000 00:00:00 GMT'],
                false
            ]
        ];
    }

    /**
     * @dataProvider cacheControlData
     * @param $req_headers
     * @param $res_headers
     * @param $expected
     */
    public function testCacheControl($req_headers, $res_headers, $expected)
    {
        self::assertEquals($expected, fresh($req_headers, $res_headers));
    }
}
