<?php

namespace Press\Utils;


class Utils
{
    /**
     * @param $val
     * @return string
     */
    public static function compile_etag($val)
    {
        return md5($val);
    }

    /**
     * @param $val
     * @return \Closure
     */
    public static function compile_query_parser($val)
    {
        if (is_callable($val)) {
            return $val;
        }

        return function ($str) {
            parse_url($str);
        };
    }

    /**
     * @param $val
     * @return \Closure
     */
    public static function compile_trust($val)
    {
        if (is_callable($val)) {
            return $val;
        }

        return ProxyAddr::compile($val);
    }
}