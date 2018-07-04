<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-7-4
 * Time: 上午8:29
 */

use Press\Utils\Mime\MimeTypes;
use PHPUnit\Framework\TestCase;


class MimeTypesTest extends TestCase
{
    /**
     * @return array
     */
    public function charsetData()
    {
        return [
            [
                'application/json', 'UTF-8'
            ],
            [
                'application/json; foo=bar', 'UTF-8'
            ],
            [
                'application/javascript', 'UTF-8'
            ],
            [
                'application/JavaScript', 'UTF-8'
            ],
            [
                'text/html', 'UTF-8'
            ],
            [
                'TEXT/HTML', 'UTF-8'
            ],
            [
                'application/x-bogus', false
            ],
            [
                'application/octet-stream', false
            ],
            [
                [], false
            ],
            [
                null, false
            ],
            [
                true, false
            ],
            [
                42, false
            ],
            [
                'hello', false
            ]
        ];
    }


    /**
     * @return array
     */
    public function contentTypeData()
    {
        return [
            [
                'html', 'text/html; charset=utf-8'
            ],
            [
                '.html', 'text/html; charset=utf-8'
            ],
            [
                'jade', 'text/html; charset=utf-8'
            ],
            [
                'json', 'application/json; charset=utf-8'
            ],
            [
                'bogus', false
            ],
            [
                [], false
            ],
            [
                null, false
            ],
            [
                true, false
            ],
            [
                42, false
            ],
            [
                'application/json', 'application/json; charset=utf-8'
            ],
            [
                'application/json; foo=bar', 'application/json; foo=bar; charset=utf-8'
            ],
            [
                'TEXT/HTML', 'TEXT/HTML; charset=utf-8'
            ],
            [
                'text/html', 'text/html; charset=utf-8'
            ],
            [
                'text/html; charset=iso-8859-1', 'text/html; charset=iso-8859-1'
            ],
            [
                'application/x-bogus', 'application/x-bogus'
            ]
        ];
    }


    /**
     * @return array
     */
    public function extensionData()
    {
        return [
            [
                'text/html', 'html'
            ],
            [
                ' text/html', 'html'
            ],
            [
                'text/html', 'html'
            ],
            [
                'application/x-bogus', false
            ],
            [
                'bogus', false
            ],
            [
                null, false
            ],
            [
                [], false
            ],
            [
                42, false
            ],
            [
                'text/html;charset=UTF-8', 'html'
            ],
            [
                'text/HTML; charset=UTF-8', 'html'
            ],
            [
                'text/html; charset=UTF-8', 'html'
            ],
            [
                'text/html; charset=UTF-8 ', 'html'
            ],
            [
                'text/html ; charset=UTF-8', 'html'
            ]
        ];
    }


    /**
     * @return array
     */
    public function lookupData()
    {
        return [
            [
                '.html', 'text/html'
            ],
            [
                '.js', 'application/javascript'
            ],
            [
                '.json', 'application/json'
            ],
            [
                '.rtf', 'application/rtf'
            ],
            [
                '.txt', 'text/plain'
            ],
            [
                '.xml', 'application/xml'
            ],
            [
                'HTML', 'text/html'
            ],
            [
                '.Xml', 'application/xml'
            ],
            [
                '.bogus', false
            ],
            [
                'bogus', false
            ],
            [
                null, false
            ],
            [
                12, false
            ],
            [
                [], false
            ],
            [
                'page.html', 'text/html'
            ],
            [
                'path/to/page.html', 'text/html'
            ],
            [
                'path\\to\\page.html', 'text/html'
            ],
            [
                '/absolute/path/to/page.html', 'text/html'
            ],
            [
                'C:\\path\\to\\page.html', 'text/html'
            ],
            [
                '/path/to/PAGE.HTML', 'text/html'
            ],
            [
                'C:\\path\\to\\PAGE.HTML', 'text/html'
            ],
            [
                'path/to/file.bogus', false
            ],
            [
                'path/to/json', false
            ],
            [
                'path/to/.json', false
            ],
            [
                'path/to/.config.json', 'application/json'
            ],
               [
                '.config.json', 'application/json'
            ]
        ];
    }


    /**
     * @dataProvider charsetData
     * @param $str
     * @param $expected
     */
    public function testCharset($str, $expected)
    {
        $str = MimeTypes::charset($str);
        self::assertEquals($str, $expected);
    }

    /**
     * @dataProvider contentTypeData
     */
    public function contentType()
    {

    }

    /**
     * @dataProvider extensionData
     */
    public function extension()
    {

    }

    /**
     * @dataProvider lookupData
     */
    public function lookup()
    {

    }
}
