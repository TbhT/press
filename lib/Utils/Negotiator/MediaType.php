<?php
declare(strict_types=1);

namespace Press\Utils\Negotiator;


class MediaType
{
    private static function parseAccept(string $accept)
    {
        $accepts = self::splitMediaTypes($accept);
        $m_length = count($accepts);
        $accepts_ = [];

        for ($i = 0, $j = 0; $i < $m_length; $i++) {
            $val = trim($accepts[$i]);
            $media_type = self::parseMediaType($val, $i);

            if (empty($media_type) === false) {
                $accepts_[$j++] = $media_type;
            }
        }

//        $accepts['length'] = $j;

        return $accepts_;
    }


    private static function splitMediaTypes(string $accept)
    {
        $accepts = explode(',', $accept);

        for ($i = 1, $j = 0; $i < count($accepts); $i++) {
            if (Tool::quote_count($accepts[$j]) % 2 === 0) {
                $accepts[++$j] = $accepts[$i];
            } else {
                $accepts[$j] .= (',' . $accepts[$i]);
            }
        }

//        $accepts['length'] = $j + 1;
        $accepts = array_slice($accepts, 0, $j + 1);

        return $accepts;
    }


    private static function parseMediaType(string $accept, int $i = -1)
    {
        preg_match('/^\s*([^\s\/;]+)\/([^;\s]+)\s*(?:;(.*))?$/', $accept, $matches);
        $m_length = count($matches);
        if ($m_length === 0) return null;

        $params = [];
        $q = 1;
        $sub_type = $matches[2];
        $type = $matches[1];

        if ($m_length > 3) {
            $kvps = self::splitParameters($matches[3]);
            $kvps = array_map(Tool::split_key_val_pair(), $kvps);

            foreach ($kvps as $item) {
                $pair = $item;
                $key = strtolower($pair[0]);
                $val = $pair[1];


                // get the values, unwrapping quotes

                $value = $val && $val[0] === '"' && $val[strlen($val) - 1] === '"' ?
                    substr($val, 1, strlen($val) - 2) : $val;

                if ($key === 'q') {
                    $q = floatval($value);
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
        $priority = ['o' => -1, 'q' => 0, 's' => 0];
        $cmp_array = ['s', 'q', 'o'];

        foreach ($accepted as $key => $item) {
            $spec = self::specify($type, $accepted[$key], $index);
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
        $origin_length = count($keys);
        if ($origin_length > 0) {
            $keys = array_filter($keys, function ($k) use ($spec, $p) {
                $spec_params = empty($spec['params'][$k]) ? '' : $spec['params'][$k];
                $p_params = empty($p['params'][$k]) ? '' : $p['params'][$k];
                return $spec['params'][$k] === '*' || strtolower($spec_params) === strtolower($p_params);
            });
            $changed_length = count($keys);
            if ($changed_length < $origin_length) {
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
        for ($i = 1, $j = 0; $i < count($parameters); $i++) {
            if (Tool::quote_count($parameters[$i]) % 2 === 0) {
                $parameters[++$j] = $parameters[$i];
            } else {
                $parameters[$j] .= (';' . $parameters[$i]);
            }
        }

//        $parameters['length'] = $j + 1;

        foreach ($parameters as $key => $parameter) {
            $parameters[$key] = trim($parameter);
        }

        return $parameters;
    }


    public static function preferredMediaTypes($accept = null, $provided = null)
    {
        // RFC 2616 sec 14.2: no header = */*
        $accept = $accept === null ? '*/*' : $accept;
        $accepts = self::parseAccept($accept);

        if (!$provided && is_array($provided) === false) {
            $f = array_filter($accepts, Tool::is_quality());
//         compare specs
            usort($f, Tool::compare_specs());
            return array_map(Tool::get_full_type(), $f);
        }

        $priorities = [];
        foreach ($provided as $key => $val) {
            $priorities[$key] = self::getMediaTypePriority($val, $accepts, $key);
        }

        $priorities_ = array_filter($priorities, Tool::is_quality());
        // sorted list of accepted media types

        usort($priorities_, Tool::compare_specs());
        return array_map(function ($p) use ($provided, $priorities) {
            $index = array_search($p, $priorities);
            return $provided[$index];
        }, $priorities_);
    }


}