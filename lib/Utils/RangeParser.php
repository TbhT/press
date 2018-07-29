<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-7-28
 * Time: 下午12:40
 */

namespace Press\Utils;


class RangeParser
{

    public static function rangeParser($size, $str, $options)
    {
        if (is_string($str) === false) {
            throw new \TypeError('argument $str must be string');
        }

        $index = strpos($str, '=');
        if ($index === false) {
            return -2;
        }

        // split the range string
        $arr = explode(',', substr($str, $index + 1));
        $ranges = [];

        // add ranges types todo : maybe can be refactor
//        $ranges['type'] = substr(0, $index);

        // parse all ranges
        foreach ($arr as $v) {
            $range = explode('-', $v);
            $start = intval($range[0], 10);
            $end = intval($range[1], 10);

            // -nnn
            if ($range[0] === '') {
                $end = intval($range[1], 10);
                $start = $size - $end;
                $end = $size - 1;

                // nnn-
            } else if ($range[1] === '') {
                $end = $size - 1;
            }

            // limit last-byte-pos to current length
            if ($end > $size - 1) {
                $end = $size - 1;
            }

            // invalid or unsatisifiable
            if (!is_numeric($range[0]) || !is_numeric($range[1]) || $start > $end || $start < 0) {
                continue;
            }

            array_push($ranges, ['start' => $start, 'end' => $end]);
        }

        if (count($ranges) < 1) {
            // unsatisifiable
            return -1;
        }

        return $options && $options['combine'] ? self::combineRanges($ranges) : $ranges;
    }


    private static function combineRanges($ranges)
    {
        $ranges = array_map(static::mapWithIndex(), $ranges);
        usort($ranges, static::sortByRangeIndex());
        $ordered = [];
        $ordered[0] = $ranges[0];

        for ($j = 0, $i = 1; $i < count($ranges); $i++) {
            $range = $ranges[$i];
            $current = $ranges[$j];

            if ($range['start'] > $current['end'] + 1) {
                // next range
                $ordered[++$j] = $range;
            } else if ($range['end'] > $current['end']) {
                // extend range
                $current['end'] = $range['end'];
                $current['index'] = min($current['index'], $range['index']);
            }
        }

        usort($ordered, static::sortByRangeIndex());
        $ordered = array_map(static::mapWithoutIndex(), $ordered);

        return $ordered;
    }

    private static function mapWithIndex()
    {
        return function ($range, $index) {
            return [
                'start' => $range['start'],
                'end' => $range['end'],
                'index' => $index
            ];
        };
    }

    private static function mapWithoutIndex()
    {
        return function ($range) {
            return [
                'start' => $range['start'],
                'end' => $range['end']
            ];
        };
    }

    private static function sortByRangeIndex()
    {
        return function ($a, $b) {
            return $a['index'] - $b['index'];
        };
    }

    private static function sortByRangeStart()
    {
        return function ($a, $b) {
            return $a['start'] - $b['start'];
        };
    }
}