<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-25
 * Time: 下午10:06
 */

namespace Press\Utils\Negotiator;


function get_full_languages()
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
        $suffix = $matches[2];
        $full = $prefix;

        if (empty($suffix) === false) $full .= $suffix . '-';

        $q = 1;
        if ($matches[3]) {
            $params = explode(';', $matches[3]);
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
                    if ($priority[$cmp_key] - $spec[$cmp_key] < 0) {
                        $priority = $spec;
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

        if (!$provided) {
            $f = array_filter($provided, is_quality());

//         compare specs
            usort($f, compare_specs());
            return array_map(get_full_languages(), $f);
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