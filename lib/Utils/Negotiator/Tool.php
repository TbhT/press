<?php
declare(strict_types=1);

namespace Press\Utils\Negotiator;

use Press\Utils\Mime;


class Tool
{
    public static function compare_specs()
    {
        return function ($a, $b) {
            $flag = 0;
            $cmp_array = ['q', 's', 'o', 'i'];
            foreach ($cmp_array as $value) {
                if ($value === 'q' || $value === 's') {
                    $cmp = static::array_key_compare($b, $a, $value);
                } else {
                    $cmp = static::array_key_compare($a, $b, $value);
                }

                if ($cmp !== 0) {
                    $flag = $cmp > 0 ? 1 : -1;
                    break;
                }
            }

            return $flag;
        };
    }

    public static function array_key_compare($a, $b, $key)
    {
        return array_key_exists($key, $a) ? $a[$key] - $b[$key] : 0;
    }

    public static function is_quality()
    {
        return function ($spec) {
            return $spec['q'] > 0;
        };
    }

    public static function get_full_encoding()
    {
        return function ($spec) {
            return $spec['encoding'];
        };
    }

    public static function get_full_charset()
    {
        return function ($spec) {
            return $spec['charset'];
        };
    }

    public static function get_full_languages()
    {
        return function ($spec) {
            return $spec['full'];
        };
    }

    public static function get_full_type()
    {
        return function (array $spec) {
            return "{$spec['type']}/{$spec['subtype']}";
        };
    }


    public static function quote_count(string $str): int
    {
        $count = 0;
        $offset = 0;

        while (($offset = strpos($str, '"', $offset)) !== false) {
            $count++;
//        $offset = strpos($str, '""', $offset);
            $offset++;
        }

        return $count;
    }


    public static function split_key_val_pair()
    {
        return function (string $str): array {
            $index = strpos($str, '=');
            $val = null;

            if ($index === false) {
                $key = $str;
            } else {
                $key = substr($str, 0, $index);
                $val = substr($str, $index + 1);
            }

            return [$key, $val];
        };
    }


    public static function priority_compare_result($a, $b, $key)
    {
        $flag = $a[$key] - $b[$key];
        return $flag === 0;
    }


    /**
     * convert extnames to mime
     * @return \Closure
     */
    public static function ext_to_mime()
    {
        return function ($type) {
            return strpos($type, '/') === false ?
                Mime\MimeTypes::lookup($type) : $type;
        };
    }


    /**
     * @return \Closure
     */
    public static function valid_mime()
    {
        return function ($type) {
            return is_string($type);
        };
    }

}