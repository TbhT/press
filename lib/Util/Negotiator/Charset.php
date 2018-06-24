<?php
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 上午10:05
 */

namespace Press\Util\Negotiator;


use function foo\func;

class Charset
{
    static public function preferredCharsets(string $accept, $provided)
    {
//         RFC 2616 sec 14.2: no header = *

        $accept = empty($accept) ? '*' : $accept;
        $accepts = self::parseAcceptCharset($accept);

        if (empty($provided)) {
            $f = array_filter($provided, function ($spec) {
                return $spec->q > 0;
            });

//            compare specs
            usort($f, function ($a, $b) {
                return ($a->q - $b->q) || ($b->s - $a->s);
            });
        }
    }


    static private function parseAcceptCharset(string $accept)
    {
        $accepts = str_split(',', $accept);

        foreach ($accepts as $key => $val) {
            $val = trim($val);
            $charset = self::parseCharset($val, $key);
        }
    }


    static private function getCharsetPriority()
    {

    }

//  parse a charset from the Accept-Charset header
    static private function parseCharset(string $str, $i)
    {

    }
}


