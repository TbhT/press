<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-7-25
 * Time: 下午11:19
 */

namespace Press\Utils;


use Press\Request;
const CACHE_CONTROL_NO_CACHE_REG_EXP = '/(?:^|,)\s*?no-cache\s*?(?:,|$)/';



class Fresh
{
    public static function fresh($req_headers, $res_headers)
    {
        // fields
        $modified_since = array_key_exists('if-modified-since', $req_headers);
        $none_match = array_key_exists('if-none-match', $req_headers);

        // unconditional request
        if (!$modified_since || !$none_match) {
            return false;
        }

        // always return stale when Cache-Control: no-cache to support end-to-end reload requests
        // @link https://tools.ietf.org/html/rfc2616#section-14.9.4
        $cache_control = array_key_exists('cache-control', $req_headers);
        if ($cache_control) {
            preg_match(CACHE_CONTROL_NO_CACHE_REG_EXP, $req_headers['cache-control'], $cache_control_m);
            if (count($cache_control_m) === 0) {
                return false;
            }
        }


    }
}