<?php
declare(strict_types=1);

namespace Press\Utils\ContentType;

use Error;
use Exception;
use TypeError;

/**
 * RegExp to match *( ";" parameter ) in RFC 7231 sec 3.1.1.1
 *
 * parameter     = token "=" ( token / quoted-string )
 * token         = 1*tchar
 * tchar         = "!" / "#" / "$" / "%" / "&" / "'" / "*"
 *               / "+" / "-" / "." / "^" / "_" / "`" / "|" / "~"
 *               / DIGIT / ALPHA
 *               ; any VCHAR, except delimiters
 * quoted-string = DQUOTE *( qdtext / quoted-pair ) DQUOTE
 * qdtext        = HTAB / SP / %x21 / %x23-5B / %x5D-7E / obs-text
 * obs-text      = %x80-FF
 * quoted-pair   = "\" ( HTAB / SP / VCHAR / obs-text )
 */

const PARAM_REG_EXP = "/; *([!#$%&'*+.^_`|~0-9A-Za-z-]+) *= *(\"(?:[\x{000b}\x{0020}\x{0021}\x{0023}-\x{005b}\x{005d}-\x{007e}\x{0080}-\x{00ff}]|\\\\[\x{000b}\x{0020}-\x{00ff}])*\"|[!#$%&'*+.^_`|~0-9A-Za-z-]+) */u";
const TEXT_REG_EXP = "/^[\x{000b}\x{0020}-\x{007e}\x{0080}-\x{00ff}]+$/u";
const TOKEN_REG_EXP = '/^[!#$%&\'*+.^_`|~0-9A-Za-z-]+$/u';

const QESC_REG_EXP = "/\\\\([\x{000b}\x{0020}-\x{00ff}])/u";

const QUOTE_REG_EXP = '/([\\"])/';

const TYPE_REG_EXP = '/^[!#$%&\'*+.^_`|~0-9A-Za-z-]+\/[!#$%&\'*+.^_`|~0-9A-Za-z-]+$/';


/**
 * @param array $t
 * @return mixed|string
 */
function format(array $t)
{
    $t = empty($t) ? [
        'parameters' => null,
        'type' => ''
    ] : $t;

    $parameters = array_key_exists('parameters', $t) ? $t['parameters'] : null;
    $type = $t['type'];

    preg_match(TYPE_REG_EXP, $type, $m);

    if (!$type || count($m) === 0) {
        throw new TypeError('invalid type');
    }

    $string = $type;

    // append parameters
    if (!empty($parameters) && gettype($parameters) === 'array') {
        ksort($parameters);
        foreach ($parameters as $key => $parameter) {
            preg_match(TOKEN_REG_EXP, $key, $m);

            if (count($m) === 0) {
                throw new TypeError('invalid parameter name');
            }

            $qs_string = qsString($parameter);
            $string .= "; {$key}={$qs_string}";
        }
    }

    return $string;
}

/**
 * @param $string
 * @return array|void
 * @throws Exception
 */
function parse($string)
{
    $header = gettype($string) === 'object' ?
        getContentType($string) : $string;

    if (!is_string($header)) {
        throw new Exception('argument string is required to be a a string');
    }

    $index = strpos($header, ';');
    $type = $index !== false ? trim(substr($header, 0, $index)) : trim($header);
    $type = strtolower($type);

    preg_match(TYPE_REG_EXP, $type, $m);
    if (count($m) === 0) {
        throw new TypeError('invalid media type');
    }

    $ar = arrayContentType($type);

    if ($index !== false) {
        preg_match_all(PARAM_REG_EXP, $header, $m, PREG_OFFSET_CAPTURE, $index);
        if (count($m) === 0) {
            return;
        }

        foreach ($m[0] as $k => $item) {
            if ($item[1] !== $index) {
                throw new Exception('invalid parameter format');
            }

            $index += strlen($item[0]);
            $key = strtolower($m[1][$k][0]);
            $value = $m[2][$k][0];

            if ($value[0] === '"') {
                // remove quotes and escapes
                $value = substr($value, 1, strlen($value) - 2);
                $value = preg_replace(QESC_REG_EXP, '$1', $value);
            }

            $ar['parameters'][$key] = $value;
        }

        if ($index !== strlen($header)) {
            throw new TypeError('invalid parameter format');
        }
    }

    return $ar;
}

/**
 * @param $type
 * @return array
 */
function arrayContentType($type)
{
    return [
        'parameters' => [],
        'type' => $type
    ];
}

/**
 * @param {Request|Response} $string
 * @return mixed
 * @throws Exception
 */
function getContentType($string)
{
    $header = $string->get('content-type');

    if (!$header) {
        throw new Exception('content-type is missing from object');
    }

    return $header;
}


/**
 * @param string $val
 * @return string
 */
function qsString(string $val)
{
    //no need to quote tokens
    preg_match(TOKEN_REG_EXP, $val, $m);
    if (count($m) > 0) {
        return $val;
    }

    if (strlen($val) > 0) {
        preg_match(TEXT_REG_EXP, $val, $m);
        if (count($m) === 0) {
            throw new TypeError('invalid parameter value');
        }
    }

    $str = preg_replace(QUOTE_REG_EXP, '\\\\$1', $val);
    return "\"{$str}\"";
}
