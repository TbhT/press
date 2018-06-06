<?php
declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use Press\Tool\ArrayHelper;


/**
 * Class FlattenArrayTest
 */
class ArrayHelperTest extends TestCase
{
    public function testCascadeArray()
    {
        return [
            'one' => [
                [10, 11, 12, 13, 14, 15],
                [10, 11, 12, 13, 14, 15]
            ],
            'two' => [
                [10, [11, 12], [13, 14], 15],
                [10, 11, 12, 13, 14, 15]
            ],
            'three' => [
                [10, [11, [12]], [13, [14]], 15],
                [10, 11, 12, 13, 14, 15]
            ],
            'forth' => [
                [10, [11, [12, [13]]], 14, 15],
                [10, 11, 12, 13, 14, 15]
            ],
            'fifth' => [
                [10, [11, [12, [13, [14]]]], 15],
                [10, 11, 12, 13, 14, 15]
            ]
        ];
    }


    /**
     * @dataProvider testCascadeArray
     * @param array $t
     * @param array $expected
     */
    public function testFlattenArray(array $t, array $expected)
    {
        $result = ArrayHelper::flattenArray($t);
        static::assertEquals($expected, $result);
    }
}