<?php
declare(strict_types=1);

use Press\Utils\RangeParser;
use PHPUnit\Framework\TestCase;


class RangeParserTest extends TestCase
{
    /**
     * @expectedException TypeError
     */
    public function testRejectNonString()
    {
        RangeParser::rangeParser(200, []);
    }

    public function testInvalidStr()
    {
        self::assertEquals(-2, RangeParser::rangeParser(200, 'malformed'));
    }

    public function testAllSpecifiedRangesAreInvalid()
    {
        self::assertEquals(-1, RangeParser::rangeParser(200, 'bytes=500-20'));
        self::assertEquals(-1, RangeParser::rangeParser(200, 'bytes=500-999'));
        self::assertEquals(-1, RangeParser::rangeParser(200, 'bytes=500-999,1000-1499'));
    }

    public function testParseStr()
    {
        $range = RangeParser::rangeParser(1000, 'bytes=0-499');
        self::assertEquals(1, count($range));
        self::assertEquals(['start' => 0, 'end' => 499], $range[0]);
    }

    public function testCapEndAtSize()
    {
        $range = RangeParser::rangeParser(200, 'bytes=0-499');
        self::assertEquals(1, count($range));
        self::assertEquals($range[0], ['start' => 0, 'end' => 199]);
    }

    public function testParseStr2()
    {
        $range = RangeParser::rangeParser(1000, 'bytes=40-80');
        self::assertEquals(1, count($range));
        self::assertEquals($range[0], ['start' => 40, 'end' =>  '80']);
    }

    public function testParseStrAskForLastNBytes()
    {
        $range = RangeParser::rangeParser(1000, 'bytes=-400');
        self::assertEquals(1, count($range));
        self::assertEquals($range[0], ['start' => 600, 'end' => 999]);
    }

    public function testParseStrWithOnlyStart()
    {
        $range = RangeParser::rangeParser(1000, 'bytes=400-');
        self::assertEquals(1, count($range));
        self::assertEquals($range[0], ['start' => 400, 'end' => 999]);
    }

    public function testParse0Bytes()
    {
        $range = RangeParser::rangeParser(1000, 'bytes=0-');
        self::assertEquals(1, count($range));
        self::assertEquals($range[0], ['start' => 0, 'end' => 999]);
    }

    public function testParseStrAskForLastByte()
    {
        $range = RangeParser::rangeParser(1000, 'bytes=-1');
        self::assertEquals(1, count($range));
        self::assertEquals($range[0], ['start' => 999, 'end' => 999]);
    }

    public function testParseStrWithMultiRanges()
    {
        $range = RangeParser::rangeParser(1000, 'bytes=40-80, 81-90, -1');
        self::assertEquals(3, count($range));
        self::assertEquals($range[0], ['start' => 40, 'end' => '80']);
        self::assertEquals($range[1], ['start' => 81, 'end' => '90']);
        self::assertEquals($range[2], ['start' => 999, 'end' => 999]);
    }

    public function testParseStrWithInvalidRanges()
    {
        $range = RangeParser::rangeParser(200, 'bytes=0-499, 1000-, 500-999');
        self::assertEquals(1, count($range));
        self::assertEquals($range[0], ['start' => 0, 'end' => 199]);
    }

    public function testNoneByteRange()
    {
        $range = RangeParser::rangeParser(1000, 'items=0-5');
        self::assertEquals(1, count($range));
        self::assertEquals($range[0], ['start' => 0, 'end' => 5]);
    }

    public function testOverlappingRanges()
    {
        $range = RangeParser::rangeParser(150, 'bytes=0-4,90-99,5-75,100-199,101-102', ['combine' => true]);
        self::assertEquals(2, count($range));
        self::assertEquals($range[0], ['start' => 0, 'end' => 75]);
        self::assertEquals($range[1], ['start' => 90, 'end' => 149]);
    }

    public function testRetainOriginalOrder()
    {
        $range = RangeParser::rangeParser(150, 'bytes=-1,20-100,0-1,101-120', ['combine' => true]);
        self::assertEquals(3, count($range));
        self::assertEquals($range[0], ['start' => 149, 'end' => 149]);
        self::assertEquals($range[1], ['start' => 20, 'end' => 120]);
        self::assertEquals($range[2], ['start' => 0, 'end' => 1]);
    }
}
