<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 上午10:05
 */

namespace Press\Utils\Negotiator;


function is_quality()
{
    return function ($spec) {
        return $spec['q'] > 0;
    };
}


function get_full_charset()
{
    return function ($spec) {
        return $spec['charset'];
    };
}


function compare_specf()
{
    return function ($a, $b) {
        return ($b['q'] - $a['q']) || ($b['s'] - $a['s']) || ($a['o'] - $b['o']) || ($a['i'] - $b['i']) || 0;
    };
}


class Charset
{
    static public function preferredCharsets(string $accept = '', $provided = null)
    {
//         RFC 2616 sec 14.2: no header = *

        $accept = empty($accept) ? '*' : $accept;
        $accepts = self::parseAcceptCharset($accept);

        if (empty($provided)) {
            $f = array_filter($provided, function ($spec) {
                return $spec['q'] > 0;
            });

//         compare specs
            usort($f, compare_specf());
            return array_map(get_full_charset(), $f);
        }

        $priorities = [];
        foreach ($provided as $key => $val) {
            $priorities[$key] = self::getCharsetPriority($val, $accepts, $key);
        }

        $priorities = array_filter($priorities, is_quality());
        // sorted list of accepted charsets
        usort($priorities, compare_specf());
        return array_map(function ($p) use ($provided, $priorities) {
            $index = array_search($p, $priorities);
            return $provided[$index];
        }, $priorities);
    }


    static private function parseAcceptCharset(string $accept)
    {
        $accepts = explode(',', $accept);

        for ($i = 0, $j = 0; $i < count($accepts); $i++) {
            $val = trim($accepts[$i]);
            $charset = self::parseCharset($val, $i);

            if (empty($charset) === false) {
                $accepts[$j++] = $charset;
            }
        }

//      rim accepts
        $accepts['length'] = $j;

        return $accepts;
    }


//      parse a charset from the Accept-Charset header
    static private function parseCharset(string $str, $i)
    {
        preg_match_all('/^\s*([^\s;]+)\s*(?:;(.*))?$/', $str, $matches);
        $m_length = count($matches);
        if ($m_length === 0) return null;

        $charset = $matches[1];
        $q = 1;
        if ($m_length >= 2) {
            $params = explode(';', $matches[2]);

            foreach ($params as $key => $val) {
                $vs = explode('=', $val);
                if ($vs[0] === 'q') {
                    $q = floatval($vs[1]);
                    break;
                }
            }
        }

        return [
            'charset' => $charset,
            'q' => $q,
            'i' => $i
        ];
    }


//    get priority of a charset
    static private function getCharsetPriority($charset, $accepted, $index): array
    {
        $priority = ['o' => -1, 'q' => 0, 's' => 0];

        foreach ($accepted as $key => $val) {
            $spec = self::specify($charset, $val, $index);
            $flag = ($priority['s'] - $spec['s'] || $priority['q'] - $spec['q'] || $priority['o'] - $spec['o']);
            if ($spec && $flag < 0) {
                $priority = $spec;
            }
        }

        return $priority;
    }


//    get the specificity of the charset
    static private function specify(string $charset, array $spec, $index)
    {
        $s = 0;

        if (strtolower($charset) === strtolower($spec['charset'])) {
            $s |= 1;
        } elseif ($spec['charset'] !== '*') {
            return null;
        }

        return [
            'i' => $index,
            'o' => $spec['i'],
            'q' => $spec['q'],
            's' => $s
        ];
    }
}


