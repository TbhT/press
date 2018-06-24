<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 下午9:49
 */

namespace Press\Utils\Negotiator;


function get_full_encoding()
{
    return function ($spec) {
        return $spec['encoding'];
    };
}


class Encoding
{
    /**
     * parse the accept-encoding header
     * @param string $accept
     * @return array
     */
    private static function parseAcceptEncoding(string $accept)
    {
        $accepts = explode(',', $accept);
        $has_identity = false;
        $min_quality = 1;

        for ($i = 0, $j = 0; $i < count($accepts); $i++) {
            $val = trim($accepts[$i]);
            $encoding = self::parseEncoding($val, $i);

            if (empty($encoding) === false) {
                $accepts[$j++] = $encoding;
                $has_identity = $has_identity || self::specify('identity', $encoding);
                $min_quality = min($min_quality, ($encoding['q'] || 1));
            }
        }

        if (!$has_identity) {
//          If identity doesn't explicitly appear in the accept-encoding header,
//          it's added to the list of acceptable encoding with the lowest q
            $accepts[$j++] = [
                'encoding' => 'identity',
                'q' => $min_quality,
                'i' => $i
            ];
        }

        $accepts['length'] = $j;

        return $accepts;
    }


    /**
     * parse an encoding from the accept-encoding header
     * @param string $str
     * @param int $i
     * @return null
     */
    private static function parseEncoding(string $str, int $i)
    {
        preg_match_all('/^\s*([^\s;]+)\s*(?:;(.*))?$/', $str, $matches);
        $m_length = count($matches);
        if ($m_length === 0) return null;

        $encoding = $matches[1];
        $q = 1;
        if ($m_length >= 2) {
            $params = explode(';', $matches[2]);

            foreach ($params as $key => $val) {
                $vs = explode('=', $val);
                if ($vs[0] === 'q') {
                    $q = $vs[1];
                    break;
                }
            }
        }

        return [
            'encoding' => $encoding,
            'q' => $q,
            'i' => $i
        ];
    }

//  get the specificity of the encoding
    private static function specify(string $encoding, array $spec, int $index)
    {
        $s = 0;
        if (strtolower($spec['encoding']) === strtolower($encoding)) {
            $s |= 1;
        } elseif ($spec['encoding'] !== '*') {
            return null;
        }

        return [
            'i' => $index,
            'o' => $spec['i'],
            'q' => $spec['q'],
            's' => $s
        ];
    }


    /**
     * @param string $accept
     * @param $provided
     * @return array
     */
    public static function prefferedEncodings(string $accept = '', $provided)
    {
        $accepts = self::parseAcceptEncoding($accept);

        if (empty($provided)) {
            $f = array_filter($provided, function ($spec) {
                return $spec['q'] > 0;
            });

            usort($f, compare_specf());
            return array_map(get_full_encoding(), $f);
        }

        $priorities = [];
        foreach ($priorities as $key => $priority) {
            $priorities[$key] = self::getEncodingPriority($priority, $accepts, $key);
        }

        $priorities = array_filter($priorities, is_quality());
        // sorted list of accepted encodings
        usort($priorities, compare_specf());
        return array_map(function ($p) use ($provided, $priorities) {
            $index = array_search($p, $priorities);
            return $provided[$index];
        }, $priorities);
    }


    /**
     * get the priority of the encoding
     * @param $encoding
     * @param $accepted
     * @param $index
     * @return array|null
     */
    private static function getEncodingPriority($encoding, $accepted, $index)
    {
        $priority = [
            'o' => -1,
            'q' => 0,
            's' => 0
        ];

        foreach ($accepted as $item) {
            $spec = self::specify($encoding, $item, $index);
            $flag = ($priority['s'] - $spec['s'] || $priority['q'] - $spec['q'] || $priority['o'] - $spec['o']);
            if ($spec && $flag < 0) {
                $priority = $spec;
            }
        }

        return $priority;
    }
}