<?php

namespace Press\Utils;


use Press\Response;

/**
 * RegExp to match field-name in RFC 7230 sec 3.2
 *
 * field-name    = token
 * token         = 1*tchar
 * tchar         = "!" / "#" / "$" / "%" / "&" / "'" / "*"
 *               / "+" / "-" / "." / "^" / "_" / "`" / "|" / "~"
 *               / DIGIT / ALPHA
 *               ; any VCHAR, except delimiters
 */
const FILED_NAME_REGEXP = '/^[!#$%&\'*+\-.^_`|~0-9A-Za-z]+$]/';


class Vary
{

    private function append(string $header, $field)
    {
        $fields = !is_array($field) ? self::parse($field) : $field;

        // assert on invalid field names
        foreach ($fields as $field) {
            preg_match(FILED_NAME_REGEXP, $field, $match);
            if (count($match) === 0) {
                throw new \TypeError('field argument contains an invalid header name');
            }
        }

        // existing, unspecified vary
        if ($header === '*') {
            return $header;
        }

        // enumerate current values
        $val = $header;
        $vals = self::parse(strtolower($header));

        // unspecified vary
        if (array_search('*', $fields) !== false || array_search('*', $vals) !== false) {
            return '*';
        }

        foreach ($fields as $field) {
            $fld = strtolower($field);

            // append value (case-preserving)
            if (array_search($fld, $vals) === false) {
                array_push($vals, $fld);
                $val = $val ? "{$val}, {$field}" : $field;
            }
        }

        return $val;
    }

    /**
     * @param string $field
     * @return array
     */
    private static function parse(string $field)
    {
        $end = 0;
        $list = [];
        $start = 0;
        $len = strlen($field);

        for ($i = 0; $i < $len; $i++) {
            switch (ord($field[$i])) {
                // space
                case 0x20:
                    if ($start === $end) {
                        $start = $end = $i + 1;
                    }
                    break;
                // comma
                case 0x2c:
                    array_push($list, substr($field, $start, $end));
                    $start = $end = $i + 1;
                    break;
                default:
                    $end = $i + 1;
                    break;
            }
        }

        // final token
        array_push($list, substr($field, $start, $end));

        return $list;
    }

    public function vary(Response $res, $field)
    {
        // get existing header
        $val = (string)$res->get('Vary');
        $header = is_array($val);
    }


}