<?php
declare(strict_types=1);


use Press\Utils\ContentType;
use PHPUnit\Framework\TestCase;

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
}
