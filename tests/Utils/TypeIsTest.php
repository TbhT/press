<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-7-21
 * Time: 下午2:28
 */

use Press\Request;
use Press\Utils\TypeIs;
use PHPUnit\Framework\TestCase;


class TypeIsTest extends TestCase
{
    private function createRequest($type)
    {
        $req = new Request();
        $type = !$type ? '' :  $type;
        $req->headers['content-type'] = $type;
        $req->headers['transfer-encoding'] = 'chunked';
        return $req;
    }

    /**
     * request, $type, expected
     * @return array
     */
    public function typeIsData()
    {
        return [
            [
                'text/html; charset=utf-8', ['text/*'], 'text/html'
            ],
            [
                'text/html ; charset=utf-8', ['text/*'], 'text/html'
            ],
            [
                'text/HTML', ['text/*'], 'text/html'
            ],
//            [
//                'text/html**', ['text/*'], false
//            ],
//            [
//                'text/html', ['text/html/'], false
//            ],
//            [
//                'text/html', [null, true, function () {}], false
//            ]
        ];
    }

    public function testNoBodyTypeIs()
    {
        $req = new Request();
        $req->headers = [];

        self::assertEquals(null, TypeIs::typeOfRequest($req));
        self::assertEquals(null, TypeIs::typeOfRequest($req, ['image/*']));
        self::assertEquals(null, TypeIs::typeOfRequest($req, 'image/*', 'text/*'));
    }

    /**
     * @dataProvider typeIsData
     * @param $header
     * @param $type
     * @param $expected
     */
    public function testTypeIs($header, $type, $expected)
    {
        $req = $this->createRequest($header);
        $result = TypeIs::typeOfRequest($req, $type);

        self::assertEquals($expected, $result);
    }
}
