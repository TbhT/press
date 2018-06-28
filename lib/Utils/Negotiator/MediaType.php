<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-26
 * Time: 下午7:23
 */

namespace Press\Utils\Negotiator;


function get_full_type()
{
    return function (array $spec) {
        return "{$spec['type']}/{$spec['subtype']}";
    };
}


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


function split_key_val_pair()
{
    return function (string $str): array {
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

            foreach ($kvps as $item) {
                $pair = $item;
                $key = strtolower($pair[0]);
                $val = $pair[1];


                // get the values, unwrapping quotes
                $str_length = strlen($val);
                $value = $val && $val[0] === '"' && $val[$str_length - 1] === '"' ?
                    substr($val, 1, $str_length - 2) : $val;

                if ($key === 'q') {
                    $q = floatval($key);
                    break;
                }

                // store parameter
                $params[$key] = $value;
            }
        }

        return [
            'type' => $type,
            'subtype' => $sub_type,
            'params' => $params,
            'q' => $q,
            'i' => $i
        ];
    }

    // get the priority of a media type
    private static function getMediaTypePriority($type, $accepted, $index)
    {
        $priority = [
            'o' => -1,
            'q' => 0,
            's' => 0
        ];

        foreach ($accepted as $key => $item) {
            $spec = self::specify($type, $accepted[$key], $index);
            //  todo why this sort type
            $flag = ($priority['s'] - $spec['s'] || $priority['q'] - $spec['q'] || $priority['o'] - $spec['o']);
            if ($spec && $flag < 0) {
                $priority = $spec;
            }
        }

        return $priority;

    }

    private static function specify($type, $spec, $index)
    {
        $p = self::parseMediaType($type);
        $s = 0;

        if (empty($p)) return null;

        if (strtolower($spec['type']) === strtolower($p['type'])) {
            $s |= 4;
        } else if ($spec['type'] !== '*') {
            return null;
        }

        if (strtolower($spec['subtype']) === strtolower($p['subtype'])) {
            $s |= 2;
        } else if ($spec['subtype'] !== '*') {
            return null;
        }

        $keys = array_keys($spec['params']);
        if (count($keys) > 0) {
            $keys = array_filter($keys, function ($k) use ($spec, $p) {
                return $spec['params'][$k] === '*' || strtolower($spec['params'][$k] || '') === strtolower($p['params'][$k] || '');
            });
            if (count($keys) > 0) {
                return null;
            } else {
                $s |= 1;
            }
        }

        return [
            'i' => $index,
            'o' => $spec['i'],
            'q' => $spec['q'],
            's' => $s
        ];
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

    public static function preferredMediaTypes(string $accept = '', $provided = null)
    {
        // RFC 2616 sec 14.2: no header = */*
        $accept = empty($accept) ? '*/*' : $accept;
        $accepts = self::parseAccept($accept);

        if (empty($provided)) {
            $f = array_filter($provided, function ($spec) {
                return $spec['q'] > 0;
            });

//         compare specs
            usort($f, compare_specf());
            return array_map(get_full_type(), $f);
        }

        $priorities = [];
        foreach ($provided as $key => $val) {
            $priorities[$key] = self::getMediaTypePriority($val, $accepts, $key);
        }

        $priorities = array_filter($priorities, is_quality());
        // sorted list of accepted media types
        return array_map(function ($p) use ($provided, $priorities) {
            $index = array_search($p, $priorities);
            return $provided[$index];
        }, $priorities);
    }
}