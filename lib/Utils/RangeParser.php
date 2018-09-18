<?php
declare(strict_types=1);

namespace Press\Utils;


class RangeParser
{

    public static function rangeParser($size, $str, $options = null)
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

        //  add ranges types todo : maybe can be refactor
        //  $ranges['type'] = substr(0, $index);

        // parse all ranges
        foreach ($arr as $v) {
            $range = explode('-', $v);
            $start = intval($range[0], 10);
            $end = intval($range[1], 10);

            // -nnn
            if (is_numeric($range[0]) === false) {
                $end = intval($range[1], 10);
                $start = $size - $end;
                $end = $size - 1;

                // nnn-
            } else if (is_numeric($range[1]) === false) {
                $end = $size - 1;
            }

            // limit last-byte-pos to current length
            if ($end > $size - 1) {
                $end = $size - 1;
            }

            // invalid or unsatisfiable
            if (!is_numeric($start) || !is_numeric($end) || $start > $end || $start < 0) {
                continue;
            }

            array_push($ranges, ['start' => $start, 'end' => $end]);
        }

        if (count($ranges) < 1) {
            // unsatisfiable
            return -1;
        }

        return $options && $options['combine'] ? self::combineRanges($ranges) : $ranges;
    }


    private static function combineRanges($ranges)
    {
        array_walk($ranges, static::mapWithIndex());
        usort($ranges, static::sortByRangeStart());

        for ($j = 0, $i = 1; $i < count($ranges); $i++) {
            $range = &$ranges[$i];
            $current = &$ranges[$j];

            if ($range['start'] > $current['end'] + 1) {
                // next range
                $ranges[++$j] = $range;
            } else if ($range['end'] > $current['end']) {
                // extend range
                $current['end'] = $range['end'];
                $current['index'] = min($current['index'], $range['index']);
            }
        }

        $ranges = array_slice($ranges, 0, $j + 1);

        usort($ranges, static::sortByRangeIndex());
        $ranges = array_map(static::mapWithoutIndex(), $ranges);

        return $ranges;
    }

    private static function mapWithIndex()
    {
        return function (& $range, $index) {
            return $range = [
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