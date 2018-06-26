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


function split_key_val_pair() {
    return function (string $str) : array {
        $index = strpos($str, '=');
        $val = null;

        if ($index === -1) {
            $key = $str;
        } else {
            $key = substr($str, $index);
            $val = substr($str, $index + 1);
        }

        return [$key, $val];
    };
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
        preg_match('/^\s*([^\s\/;]+)\/([^;\s]+)\s*(?:;(.*))?$/', $accept, $matches);
        $m_length = count($matches);
        if ($m_length === 0) return null;

        $params = [];
        $q = 1;
        $sub_type = $matches[2];
        $type = $matches[1];

        if ($matches[3]) {
            $kvps = self::splitParameters($matches[3]);
            array_map(split_key_val_pair(), $kvps);

        }
    }

    private static function splitParameters(string $str)
    {
        $parameters = explode(';', $str);
        for ($i = 0, $j = 0; $i < count($parameters); $i++) {
            if (quote_count($parameters[$i]) % 2 === 0) {
                $parameters[++$j] = $parameters[$i];
            } else {
                $parameters[$j] .= ';' . $parameters[$i];
            }
        }

        $parameters['length'] = $j + 1;

        for ($i = 0; $i < $parameters['length']; $i++) {
            $parameters[$i] = trim($parameters[$i]);
        }

        return $parameters;
    }
}