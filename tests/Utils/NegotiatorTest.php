<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 下午2:19
 */

use PHPUnit\Framework\TestCase;
use Press\Utils\Negotiator;
use Press\Request;


class NegotiatorTest extends TestCase
{

    /**
     *  accept-charset , expected
     * @return array
     */
    public function charsetData()
    {
        return [
            [
                null, '*'
            ],
            [
                '*', '*'
            ],
            [
                '*, UTF-8', '*'
            ],
            [
                '*, UTF-8;q=0', '*'
            ],
            [
                'ISO-8859-1', 'ISO-8859-1'
            ],
            [
                'UTF-8;q=0', null
            ],
            [
                'UTF-8, ISO-8859-1', 'UTF-8'
            ],
            [
                'UTF-8;q=0.8, ISO-8859-1', 'ISO-8859-1'
            ],
            [
                'UTF-8;q=0.9, ISO-8859-1;q=0.8, UTF-8;q=0.7', 'UTF-8'
            ]
        ];
    }

    /**
     *  accept-charset , expected, charset
     * @return array
     */
    public function charsetArrayData()
    {
        return [
            [
                null, null, []
            ],
            [
                null, 'UTF-8', ['UTF-8']
            ],
            [
                null, 'UTF-8', ['UTF-8', 'ISO-8859-1']
            ],
            [
                '*', null, []
            ],
            [
                '*', 'UTF-8', ['UTF-8']
            ],
            [
                '*', 'UTF-8', ['UTF-8', 'ISO-8859-1']
            ],
            [
                '*, UTF-8', 'UTF-8', ['UTF-8']
            ],
            [
                '*, UTF-8', 'UTF-8', ['UTF-8', 'ISO-8859-1']
            ],
            [
                '*, UTF-8;q=0', 'ISO-8859-1', ['UTF-8', 'ISO-8859-1']
            ],
            [
                '*, UTF-8;q=0', null, ['UTF-8']
            ],
            [
                'ISO-8859-1', 'ISO-8859-1', ['ISO-8859-1']
            ],
            [
                'ISO-8859-1', 'ISO-8859-1', ['UTF-8', 'ISO-8859-1']
            ],
            [
                'ISO-8859-1', 'iso-8859-1', ['iso-8859-1']
            ],
            [
                'ISO-8859-1', 'iso-8859-1', ['iso-8859-1', 'ISO-8859-1']
            ],
            [
                'ISO-8859-1', 'iso-8859-1', ['ISO-8859-1', 'iso-8859-1']
            ],
            [
                'UTF-8;q=0', null, ['ISO-8859-1']
            ],
            [
                'UTF-8;q=0', null, ['UTF-8', 'KOI8-R', 'ISO-8859-1']
            ],
            [
                'UTF-8;q=0', null, ['KOI8-R']
            ],
            [
                'UTF-8, ISO-8859-1', 'ISO-8859-1', ['ISO-8859-1']
            ],
            [
                'UTF-8, ISO-8859-1', 'ISO-8859-1', ['UTF-8', 'KOI8-R', 'ISO-8859-1']
            ],
            [
                'UTF-8, ISO-8859-1', null, ['KOI8-R']
            ],
            [
                'UTF-8;q=0.8, ISO-8859-1', 'ISO-8859-1', ['ISO-8859-1']
            ],
            [
                'UTF-8;q=0.8, ISO-8859-1', 'ISO-8859-1', ['UTF-8', 'KOI8-R', 'ISO-8859-1']
            ],
            [
                'UTF-8;q=0.8, ISO-8859-1', 'UTF-8', ['UTF-8', 'KOI8-R']
            ],
            [
                'UTF-8;q=0.9, ISO-8859-1;q=0.8, UTF-8;q=0.7', 'ISO-8859-1', ['ISO-8859-1']
            ],
            [
                'UTF-8;q=0.9, ISO-8859-1;q=0.8, UTF-8;q=0.7', 'UTF-8', ['UTF-8', 'ISO-8859-1']
            ],
            [
                'UTF-8;q=0.9, ISO-8859-1;q=0.8, UTF-8;q=0.7', 'UTF-8', ['ISO-8859-1', 'UTF-8'],
            ]
        ];
    }

    /**
     * accept-charset, expected
     */
    public function charsetsData()
    {
        return [
            [
                null, ['*']
            ],
            [
                '*', ['*']
            ],
            [
                '*, UTF-8', ['*', 'UTF-8']
            ],
            [
                '*, UTF-8;q=0', ['*']
            ],
            [
                'UTF-8;q=0', []
            ],
            [
                'ISO-8859-1', ['ISO-8859-1']
            ],
            [
                'UTF-8, ISO-8859-1', ['UTF-8', 'ISO-8859-1']
            ],
            [
                'UTF-8;q=0.8, ISO-8859-1', ['ISO-8859-1', 'UTF-8']
            ],
            [
                'UTF-8;q=0.9, ISO-8859-1;q=0.8, UTF-8;q=0.7', ['UTF-8', 'ISO-8859-1']
            ]
        ];
    }

    /**
     * accept-charset, expect, charsets
     * @return array
     */
    public function charsetsArrayData()
    {
        return [
            [
                null, [], []
            ],
            [
                null, ['UTF-8'], ['UTF-8']
            ],
            [
                null, ['UTF-8', 'ISO-8859-1'], ['UTF-8', 'ISO-8859-1']
            ],
            [
                '*', [], []
            ],
            [
                '*', ['UTF-8'], ['UTF-8']
            ],
            [
                '*', ['UTF-8', 'ISO-8859-1'], ['UTF-8', 'ISO-8859-1']
            ],
            [
                '*, UTF-8', ['UTF-8'], ['UTF-8']
            ],
            [
                '*, UTF-8', ['UTF-8', 'ISO-8859-1'], ['UTF-8', 'ISO-8859-1']
            ],
            [
                '*, UTF-8;q=0', [], ['UTF-8']
            ],
            [
                '*, UTF-8;q=0', ['ISO-8859-1'], ['UTF-8', 'ISO-8859-1']
            ],
            [
                'UTF-8;q=0', [], ['ISO-8859-1']
            ],
            [
                'UTF-8;q=0', [], ['UTF-8', 'KOI8-R', 'ISO-8859-1']
            ],
            [
                'UTF-8;q=0', [], ['KOI8-R']
            ],
            [
                'ISO-8859-1', ['ISO-8859-1'], ['ISO-8859-1']
            ],
            [
                'ISO-8859-1', ['ISO-8859-1'], ['UTF-8', 'ISO-8859-1']
            ],
            [
                'ISO-8859-1', ['iso-8859-1'], ['iso-8859-1']
            ],
            [
                'ISO-8859-1', ['iso-8859-1', 'ISO-8859-1'], ['iso-8859-1', 'ISO-8859-1']
            ],
            [
                'ISO-8859-1', ['ISO-8859-1', 'iso-8859-1'], ['ISO-8859-1', 'iso-8859-1']
            ],
            [
                'ISO-8859-1', [], ['utf-8']
            ],
            [
                'UTF-8, ISO-8859-1', ['ISO-8859-1'], ['ISO-8859-1']
            ],
            [
                'UTF-8, ISO-8859-1', ['UTF-8', 'ISO-8859-1'], ['UTF-8', 'KOI8-R', 'ISO-8859-1']
            ],
            [
                'UTF-8, ISO-8859-1', [], ['KOI8-R']
            ],
            [
                'UTF-8;q=0.8, ISO-8859-1', ['ISO-8859-1'], ['ISO-8859-1']
            ],
            [
                'UTF-8;q=0.8, ISO-8859-1', ['ISO-8859-1', 'UTF-8'], ['UTF-8', 'KOI8-R', 'ISO-8859-1']
            ],
            [
                'UTF-8;q=0.8, ISO-8859-1', [], ['KOI8-R']
            ],
            [
                'UTF-8;q=0.9, ISO-8859-1;q=0.8, UTF-8;q=0.7', ['ISO-8859-1'], ['ISO-8859-1']
            ],
            [
                'UTF-8;q=0.9, ISO-8859-1;q=0.8, UTF-8;q=0.7', ['UTF-8', 'ISO-8859-1'], ['UTF-8', 'ISO-8859-1']
            ],
            [
                'UTF-8;q=0.9, ISO-8859-1;q=0.8, UTF-8;q=0.7', ['UTF-8', 'ISO-8859-1'], ['ISO-8859-1', 'UTF-8']
            ]
        ];
    }


    private static function createRequest($headers)
    {
        $request = new Request();
        $request->headers = [];

        if ($headers) {
            foreach ($headers as $key => $header) {
                $request->headers[strtolower($key)] = $header;
            }
        }

        return $request;
    }

    /**
     * @dataProvider charsetData
     * @param $accept_charset
     * @param $expected
     */
    public function testCharset($accept_charset, $expected)
    {
        $request = self::createRequest(['Accept-Charset' => $accept_charset]);
        $negotiator = new Negotiator\Negotiator($request);

        $result = $negotiator->charset();
        self::assertEquals($expected, $result);
    }

    /**
     * @dataProvider charsetArrayData
     */
    public function testCharsetWithArray()
    {

    }

    /**
     * @dataProvider charsetsData
     */
    public function testCharsets()
    {

    }

    /**
     * @dataProvider charsetsArrayData
     */
    public function testCharsetsWithArray()
    {

    }
}