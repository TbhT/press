<?php

declare(strict_types=1);


namespace Press\Helper;


/**
 * Class ArrayHelper
 * @package Press\Tool
 */
class ArrayHelper
{
    /**
     * @param array $a
     * @return array
     */
    static public function flattenArray(array $a): array
    {
        $array = [];
        static::flattenForever($a, $array);
        return $array;
    }


    /**
     * @param array $a
     * @param array $result
     */
    private static function flattenForever(array $a, array & $result)
    {
        foreach ($a as $key => $val) {
            if (is_array($val)) {
                static::flattenForever($val, $result);
            } else {
                array_push($result, $val);
            }
        }
    }
}
