<?php
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-7-7
 * Time: 上午8:53
 */

use Press\Utils\Accepts;
use Press\Request;
use PHPUnit\Framework\TestCase;


class AcceptsTest extends TestCase
{
    private static function createRequestCharset($charset = null)
    {
        $req = new Request();
        $req->headers = [
            'accept-charset' => $charset
        ];

        return $req;
    }

    private static function createRequestEncoding($encoding = null)
    {
        $req = new Request();
        $req->headers = [
            'accept-encoding' => $encoding
        ];

        return $req;
    }

    private static function createRequestLanguage($language = null)
    {
        $req = new Request();
        $req->headers = [
            'accept-language' => $language
        ];

        return $req;
    }

    private static function createRequestType($type = null)
    {
        $req = new Request();
        $req->headers = [
            'accept' => $type
        ];

        return $req;
    }


    /**
     * accept-headers, expected
     * @return array
     */
    public function charsetWithNoArgumentsData()
    {
        return [
            [
                'utf-8, iso-8859-1;q=0.2, utf-7;q=0.5',
                ['utf-8', 'utf-7', 'iso-8859-1']
            ],
            [
                null, ['*']
            ],
            [
                '', []
            ]
        ];
    }

    /**
     * @dataProvider charsetWithNoArgumentsData
     * @param $accept_header
     * @param $expected
     */
    public function testCharsetWithNoArguments($accept_header, $expected)
    {
        $req = self::createRequestCharset($accept_header);
        $accept = new Accepts($req);
        $charsets = $accept->charsets();
        self::assertEquals($expected, $charsets);
    }

    public function testCharsetWithMultipleArguments()
    {
        $req1 = self::createRequestCharset('utf-8, iso-8859-1;q=0.2, utf-7;q=0.5');
        $accept1 = new Accepts($req1);
        $charsets1 = $accept1->charsets('utf-7', 'utf-8');
        self::assertEquals(['utf-8'], $charsets1);


        $req2 = self::createRequestCharset('utf-8, iso-8859-1;q=0.2, utf-7;q=0.5');
        $accept2 = new Accepts($req2);
        $charsets2 = $accept2->charsets('utf-16');
        self::assertEquals(false, $charsets2);

        $req3 = self::createRequestCharset();
        $accept3 = new Accepts($req3);
        $charsets3 = $accept3->charsets('utf-7', 'utf-8');
        self::assertEquals('utf-7', $charsets3);
    }

    public function testCharsetWithArray()
    {
        $req = self::createRequestCharset('utf-8, iso-8859-1;q=0.2, utf-7;q=0.5');
        $accept = new Accepts($req);
        $charsets = $accept->charsets(['utf-7', 'utf-8']);
        self::assertEquals('utf-8', $charsets);
    }
}
