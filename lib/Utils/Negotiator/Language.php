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
        $accepts['length'] = $j;

        return $accepts;
    }


//    Parse a language from the Accept-Language header.
    private static function parseLanguage(string $str, $i = null)
    {
        preg_match_all('/^\s*([^\s\-;]+)(?:-([^\s;]+))?\s*(?:;(.*))?$/', $str, $matches);
        $m_length = count($matches);
        if ($m_length === 0) return null;

        $prefix = $matches[1];
        $suffix = $matches[2];
        $full = $prefix;

        if (empty($suffix) === false) $full .= $suffix . '-';

        $q = 1;
        if ($matches[3]) {
            $params = explode(';', $matches[3]);

            foreach ($params as $key => $val) {
                $vs = explode('=', $val);
                if ($vs[0] === 'q') {
                    $q = $vs[1];
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
        $priority = [
            'o' => -1,
            'q' => 0,
            's' => 0
        ];

        foreach ($accepted as $key => $item) {
            $spec = self::specify($language, $accepted[$key], $index);
        //  todo why this sort type
            $flag = ($priority['s'] - $spec['s'] || $priority['q'] - $spec['q'] || $priority['o'] - $spec['o']);
            if ($spec && $flag < 0) {
                $priority = $spec;
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

    public static function prefferedLanguage(string $accept = '', $provided = null)
    {
        // RFC 2616 sec 14.4: no header = *
        $accept = empty($accept) ? '*' : $accept;
        $accepts = self::parseAcceptLanguage($accept);

        if (empty($provided)) {
            $f = array_filter($provided, function ($spec) {
                return $spec['q'] > 0;
            });

//         compare specs
            usort($f, compare_specf());
            return array_map(get_full_languages(), $f);
        }

        $priorities = [];
        foreach ($provided as $key => $val) {
            $priorities[$key] = self::getLanguagePriority($val, $accepts, $key);
        }

        $priorities = array_filter($priorities, is_quality());
        // sorted list of accepted languages
        return array_map(function ($p) use ($provided, $priorities) {
            $index = array_search($p, $priorities);
            return $provided[$index];
        }, $priorities);
    }
}