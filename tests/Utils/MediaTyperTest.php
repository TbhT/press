<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-7-20
 * Time: 下午11:20
 */

use Press\Utils\MediaTyper;
use PHPUnit\Framework\TestCase;


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
     * @expectedException TypeError
     * @param $invalid
     */
    public function testInvalidTypes($invalid)
    {
        MediaTyper::parse($invalid);
    }
}
