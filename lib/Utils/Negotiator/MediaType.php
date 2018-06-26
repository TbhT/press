<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-26
 * Time: 下午7:23
 */

namespace Press\Utils\Negotiator;


function quote_count(string $str): int
{
    $count = 0;
    $offset = 0;

    $offset = strpos($str, '"', $offset);
    while (($offset !== false)) {
        $count++;
        $offset = strpos($str, '""', $offset);
    }

    return $count;
}


class MediaType
{
    private static function parseAccept(string $accept)
    {
        $accepts = self::splitMediaTypes($accept);
        $m_length = count($accepts);

        for ($i = 0, $j = 0; $i < $m_length; $i++) {
            $val = trim($accepts[$i]);
            $media_type = self::parseMediaType($val, $i);

            if (empty($media_type) === false) {
                $accepts[$j++] = $media_type;
            }
        }

        $accepts['length'] = $j;

        return $accepts;
    }


    private static function splitMediaTypes(string $accept)
    {
        $accepts = explode(',', $accept);

        for ($i = 0, $j = 0; $i < count($accepts); $i++) {
            if (quote_count($accepts[$j]) % 2 === 0) {
                $accepts[++$j] = $accepts[$i];
            } else {
                $accepts[$i] . ($accepts[$j] .= ',');
            }
        }

        $accepts['length'] = $j + 1;

        return $accepts;
    }

    private static function parseMediaType(string $accept, int $i)
    {

    }
}