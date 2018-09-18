<?php
declare(strict_types=1);

namespace Press\Utils\Negotiator;


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
                $encoding_ = empty($encoding['q']) ? 1 : $encoding['q'];
                $min_quality = min($min_quality, $encoding_);
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

//        $accepts['length'] = $j;

        return $accepts;
    }


    /**
     * parse an encoding from the accept-encoding header
     * @param string $str
     * @param int $i
     * @return array|null
     */
    private static function parseEncoding(string $str, int $i)
    {
        preg_match('/^\s*([^\s;]+)\s*(?:;(.*))?$/', $str, $matches);
        $m_length = count($matches);
        if ($m_length === 0) return null;

        $encoding = $matches[1];
        $q = 1;
        if ($m_length > 2) {
            $params = explode(';', $matches[2]);
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
            'encoding' => $encoding,
            'q' => $q,
            'i' => $i
        ];
    }

//  get the specificity of the encoding
    private static function specify(string $encoding, array $spec, $index = -1)
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
    public static function preferredEncodings($accept = '', $provided)
    {
        $accept = empty($accept) ? '' : $accept;
        $accepts = self::parseAcceptEncoding($accept);

        if (!$provided && is_array($provided) === false) {
            $f = array_filter($accepts, Tool::is_quality());

            usort($f, Tool::compare_specs());
            return array_map(Tool::get_full_encoding(), $f);
        }

        $priorities = [];
        foreach ($provided as $key => $priority) {
            $priorities[$key] = self::getEncodingPriority($priority, $accepts, $key);
        }

        $priorities_ = array_filter($priorities, Tool::is_quality());
        // sorted list of accepted encodings
        usort($priorities_, Tool::compare_specs());
        return array_map(function ($p) use ($provided, $priorities) {
            $index = array_search($p, $priorities);
            return $provided[$index];
        }, $priorities_);
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
        $priority = ['o' => -1, 'q' => 0, 's' => 0];
        $cmp_array = ['s', 'q', 'o'];

        foreach ($accepted as $item) {
            $spec = self::specify($encoding, $item, $index);

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
}