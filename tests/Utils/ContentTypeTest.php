<?php
declare(strict_types=1);


use Press\Utils\ContentType;
use PHPUnit\Framework\TestCase;


/**
 * @param $a
 * @param $b
 * @return bool
 */
function arrays_are_similar($a, $b)
{
    foreach ($a as $k => $v) {
        if ($v !== $b[$k]) {
            return false;
        }
    }

    return true;
}


class ContentTypeTest extends TestCase
{
    public function formatData()
    {
        return [
            [
                ['type' => 'text/html'],
                'text/html'
            ],
            [
                ['type' => 'image/svg+xml'],
                'image/svg+xml'
            ],
            [
                ['type' => 'text/html', 'parameters' => ['charset' => 'utf-8']],
                'text/html; charset=utf-8'
            ],
            [
                ['type' => 'text/html', 'parameters' => ['foo' => 'bar or "baz"']],
                'text/html; foo="bar or \\"baz\\""'
            ],
            [
                ['type' => 'text/html', 'parameters' => ['foo' => '']],
                'text/html; foo=""'
            ],
            [
                ['type' => 'text/html', 'parameters' => ['charset' => 'utf-8', 'foo' => 'bar', 'bar' => 'baz']],
                'text/html; bar=baz; charset=utf-8; foo=bar'
            ]
        ];
    }

    /**
     * @dataProvider formatData
     * @param $format
     * @param $expect
     */
    public function testFormatData($format, $expect)
    {
        $str = ContentType::format($format);
        self::assertEquals($expect, $str);
    }

    /**
     * @return array
     */
    public function throwFormatData()
    {
        return [
            [null],
            [7],
            [[]],
            [['type' => 'text/']],
            [['type' => ' text/html']],
            [['type' => 'image/svg', 'parameters' => ['foo/' => 'bar']]],
            [['type' => 'image/svg', 'parameters' => ['foo' => "bar\u{0000}"]]]
        ];
    }

    /**
     * @dataProvider throwFormatData
     * @expectedException TypeError
     */
    public function testThrowFormatData($param)
    {
        ContentType::format($param);
        self::assertTrue(true);
    }

    /**
     * @return array
     */
    public function throwParseData()
    {
        return [
            [' '],
            ['null'],
            ['undefined'],
            ['/'],
            ['text / plain'],
            ['text/;plain'],
            ['text/"plain"'],
            ['text/p£ain'],
            ['text/(plain)'],
            ['text/@plain'],
            ['text/plain,wrong']
        ];
    }

    public function parseData()
    {
        return [
            ['text/html', 'text/html'],
            ['image/svg+xml', 'image/svg+xml'],
            [' text/html ', 'text/html'],
            ['text/html; charset=utf-8; foo=bar', 'text/html', [
                'charset' => 'utf-8',
                'foo' => 'bar'
            ]],
            ['text/html ; charset=utf-8 ; foo=bar', 'text/html', [
                'charset' => 'utf-8',
                'foo' => 'bar'
            ]],
            ['IMAGE/SVG+XML', 'image/svg+xml'],
            ['text/html; Charset=UTF-8', 'text/html', [
                'charset' => 'UTF-8'
            ]],
            ['text/html; charset="UTF-8"', 'text/html', [
                'charset' => 'UTF-8'
            ]],
            ['text/html; charset = "UT\\F-\\\\\\"8\\""', 'text/html', [
                'charset' => 'UTF-\\"8"'
            ]],
            ['text/html; param="charset=\\"utf-8\\"; foo=bar"; bar=foo', 'text/html', [
                'param' => 'charset="utf-8"; foo=bar',
                'bar' => 'foo'
            ]]
        ];
    }

    /**
     * @dataProvider parseData
     * @param $src
     * @param $expect1
     * @param null $expect2
     */
    public function testParseData($src, $expect1, $expect2 = null)
    {
        $type = ContentType::parse($src);
        self::assertEquals($expect1, $type['type']);

        if (!empty($expect2)) {
            self::assertTrue(arrays_are_similar($expect2, $type['parameters']));
        }
    }

    /**
     * @dataProvider throwParseData
     * @expectedException TypeError
     */
    public function testThrowParseData($val)
    {
        ContentType::parse($val);
        self::assertTrue(true);
    }
}
