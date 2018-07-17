<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-25
 * Time: 下午10:06
 */

namespace Press\Utils\Negotiator;


function array_key_compare($a, $b, $key)
{
    return array_key_exists($key, $a) ? $a[$key] - $b[$key] : 0;
}


function array_key_compare_val($a, $b, $key)
{
    return $a[$key] - $b[$key];
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


function is_quality()
{
    return function ($spec) {
        return $spec['q'] > 0;
    };
}


function  get_full_languages()
{
    return function ($spec) {
        return $spec['full'];
    };
}


class Language
{
//  Parse the Accept-Language header.
    private static function parseAcceptLanguage(string $accept): array
    {
        $accepts = explode(',', $accept);

        for ($i = 0, $j = 0; $i < count($accepts); $i++) {
            $val = trim($accepts[$i]);
            $language = self::parseLanguage($val, $i);

            if (empty($language) === false) {
                $accepts[$j++] = $language;
            }
        }

//        trim accepts
//        $accepts['length'] = $j;

        return $accepts;
    }


//    Parse a language from the Accept-Language header.
    private static function parseLanguage(string $str, $i = null)
    {
        preg_match('/^\s*([^\s\-;]+)(?:-([^\s;]+))?\s*(?:;(.*))?$/', $str, $matches);
        $m_length = count($matches);
        if ($m_length === 0) return null;

        $prefix = $matches[1];
        $suffix = '';
        $full = $prefix;

        if ($m_length > 2 && $matches[2]) {
            $suffix = $matches[2];
            $full .= '-' . $suffix;
        }

        $q = 1;
        if ($m_length > 3) {
            $params = explode(';', $matches[3]);
            for ($i = 0; $i < count($params); $i++) {
                $s = trim($params[$i]);
                $vs = explode('=', $s);
                if ($vs[0] === 'q') {
                    $q = floatval($vs[1]);
//                    break;
                }
            }
        }

        return [
            'prefix' => $prefix,
            'suffix' => $suffix,
            'q' => $q,
            'i' => $i,
            'full' => $full
        ];
    }


//    Get the priority of a language.
    private static function getLanguagePriority(string $language, array $accepted, int $index)
    {
        $priority = ['o' => -1, 'q' => 0, 's' => 0];
        $cmp_array = ['s', 'q', 'o'];

        foreach ($accepted as $key => $item) {
            $spec = self::specify($language, $accepted[$key], $index);
            //  todo why this sort type

            if ($spec) {
                foreach ($cmp_array as $cmp_key) {
                    $flag = $priority[$cmp_key] - $spec[$cmp_key];
                    if ($flag !== 0 && $flag < 0) {
                        $priority = $spec;
                        break;
                    } else if ($flag !== 0) {
                        break;
                    }
                }
            }
        }

        return $priority;
    }


    private static function specify(string $language, array $spec, int $index)
    {
        $p = self::parseLanguage($language);
        if (empty($p)) return null;

        $s = 0;
        if (strtolower($spec['full']) === strtolower($p['full'])) {
            $s |= 4;
        } elseif (strtolower($spec['prefix']) === strtolower($p['full'])) {
            $s |= 2;
        } elseif (strtolower($spec['full']) === strtolower($p['prefix'])) {
            $s |= 1;
        } elseif ($spec['full'] !== '*') {
            return null;
        }

        return [
            'i' => $index,
            'o' => $spec['i'],
            'q' => $spec['q'],
            's' => $s
        ];
    }

    public static function preferredLanguage(string $accept = '', $provided = null)
    {
        // RFC 2616 sec 14.4: no header = *
        $accept = empty($accept) ? '*' : $accept;
        $accepts = self::parseAcceptLanguage($accept);

        if (!$provided && is_array($provided) === false) {
            $f = array_filter($accepts, is_quality());

//         compare specs
            usort($f, compare_specs());
            $f = array_map(get_full_languages(), $f);
            return array_unique($f);
        }

        $priorities = [];
        foreach ($provided as $key => $val) {
            $priorities[$key] = self::getLanguagePriority($val, $accepts, $key);
        }

        $priorities_ = array_filter($priorities, is_quality());
        // sorted list of accepted languages
        usort($priorities_, compare_specs());
        return array_map(function ($p) use ($provided, $priorities) {
            $index = array_search($p, $priorities);
            return $provided[$index];
        }, $priorities_);
    }
}