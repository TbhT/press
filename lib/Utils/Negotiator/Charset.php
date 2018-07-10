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


function compare_specs()
{
    return function ($a, $b) {
        $flag = 0;
        $cmp_array = ['q', 's', 'o', 'i'];
        foreach ($cmp_array as $value) {
            if ($value === 'q' || $value === 's') {
                $cmp = array_key_compare($b, $a, $value);
            } else {
                $cmp = array_key_compare($a, $b, $value);
            }

            if ($cmp !== 0) {
                $flag = $cmp > 0 ? 1 : -1;
                break;
            }
        }

        return $flag;
    };
}


function array_key_compare($a, $b, $key)
{
    return array_key_exists($key, $a) ? $a[$key] - $b[$key] : 0;
}


function array_key_compare_val($a, $b, $key)
{
    return $a[$key] - $b[$key];
}


class Charset
{
    static public function preferredCharsets(string $accept = '', $provided = null)
    {
//         RFC 2616 sec 14.2: no header = *

        $accept = empty($accept) ? '*' : $accept;
        $accepts = self::parseAcceptCharset($accept);

        if (!$provided && is_array($provided) === false) {
            $f = array_filter($accepts, is_quality());
//         compare specs
            usort($f, compare_specs());
            return array_map(get_full_charset(), $f);
        }

        $priorities = [];
        foreach ($provided as $key => $val) {
            $charset_priority = self::getCharsetPriority($val, $accepts, $key);
            array_push($priorities, $charset_priority);
        }

        $priorities_ = array_filter($priorities, is_quality());
        // sorted list of accepted charsets
        usort($priorities_, compare_specs());
        return array_map(function ($p) use ($provided, $priorities) {
            $index = array_search($p, $priorities);
            return $provided[$index];
        }, $priorities_);
    }


    static private function parseAcceptCharset(string $accept)
    {
        $accepts = explode(',', $accept);
        $accepts_ = [];
        for ($i = 0, $j = 0; $i < count($accepts); $i++) {
            $val = trim($accepts[$i]);
            $charset = self::parseCharset($val, $i);

            if (empty($charset) === false) {
                $accepts_[$j++] = $charset;
            }
        }

//      rim accepts
//        $accepts['length'] = $j;

        return $accepts_;
    }


//      parse a charset from the Accept-Charset header
    static private function parseCharset(string $str, $i)
    {
        preg_match('/^\s*([^\s;]+)\s*(?:;(.*))?$/', $str, $matches);
        $m_length = count($matches);
        if ($m_length === 0) return null;

        $charset = $matches[1];
        $q = 1;
        if ($m_length > 2) {
            $params = explode(';', $matches[2]);

            for ($i = 0; $i < count($params); $i++) {
                $s = trim($params[$i]);
                $vs = explode('=', $s);
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
        $cmp_array = ['s', 'q', 'o'];

        foreach ($accepted as $key => $val) {
            $spec = self::specify($charset, $val, $index);

            if ($spec) {
                foreach ($cmp_array as $cmp_key) {
                    if ($priority[$cmp_key] - $spec[$cmp_key] < 0) {
                        $priority = $spec;
                        break;
                    }
                }
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


