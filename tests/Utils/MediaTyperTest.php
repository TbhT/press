<?php
declare(strict_types=1);

namespace Press\Tests\Utils;

use Press\Utils\MediaTyper;
use PHPUnit\Framework\TestCase;
use TypeError;


class MediaTyperTest extends TestCase
{
    public function invalidTypes()
    {
        return [
            [' '],
            ['null'],
            ['undefined'],
            ['/'],
            ['text/;plain'],
            ['text/"plain'],
            ['text/p£ain'],
            ['text/(plain)'],
            ['text/@plain'],
            ['text/plain,wrong']
        ];
    }

    /**
     * @dataProvider invalidTypes
     * @param $invalid
     */
    public function testInvalidTypes($invalid)
    {
        $this->expectException(TypeError::class);
        MediaTyper::parse($invalid);
    }

    public function formatData()
    {
        return [
            [
                ['type' => 'text', 'subtype' => 'html'],
                'text/html'
            ],
            [
                ['type' => 'image', 'subtype' => 'svg', 'suffix' => 'xml'],
                'image/svg+xml'
            ]
        ];
    }

    public function invalidFormatData()
    {
        return [
            [null],
            [7],
            [[]],
            [['type' => 'text/']],
            [['type' => 'text']],
            [['type' => 'text', 'subtype' => 'html/']],
            [['type' => 'image', 'subtype' => 'svg', 'suffix' => 'xml\\']]
        ];
    }

    /**
     * @dataProvider formatData
     * @param $format
     * @param $expected
     */
    public function testFormat($format, $expected)
    {
        $str = MediaTyper::format($format);
        self::assertEquals($expected, $str);
    }

    /**
     * @dataProvider invalidFormatData
     * @param $format
     */
    public function testInvalidFormat($format)
    {
        $this->expectException(TypeError::class);
        MediaTyper::format($format);
    }

    public function parseData()
    {
        return [
            [
                'text/html'

            ],
            ['image/svg+xml'],
            ['IMAGE/SVG+XML'],
        ];
    }

    public function testParse()
    {
        $text = MediaTyper::parse('text/html');
        self::assertEquals('text', $text['type']);
        self::assertEquals('html', $text['subtype']);

        $image = MediaTyper::parse('image/svg+xml');
        self::assertEquals('image', $image['type']);
        self::assertEquals('svg', $image['subtype']);
        self::assertEquals('xml', $image['suffix']);

        $caseSensitiveImage = MediaTyper::parse('IMAGE/SVG+XML');
        self::assertEquals('image', $caseSensitiveImage['type']);
        self::assertEquals('svg', $caseSensitiveImage['subtype']);
        self::assertEquals('xml', $caseSensitiveImage['suffix']);
    }
}