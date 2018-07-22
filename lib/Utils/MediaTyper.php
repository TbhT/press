<?php
declare(strict_types=1);


namespace Press\Utils;

use Press\Request;
use Press\Response;


/**
 * RegExp to match *( ";" parameter ) in RFC 2616 sec 3.7
 *
 * parameter     = token "=" ( token | quoted-string )
 * token         = 1*<any CHAR except CTLs or separators>
 * separators    = "(" | ")" | "<" | ">" | "@"
 *               | "," | ";" | ":" | "\" | <">
 *               | "/" | "[" | "]" | "?" | "="
 *               | "{" | "}" | SP | HT
 * quoted-string = ( <"> *(qdtext | quoted-pair ) <"> )
 * qdtext        = <any TEXT except <">>
 * quoted-pair   = "\" CHAR
 * CHAR          = <any US-ASCII character (octets 0 - 127)>
 * TEXT          = <any OCTET except CTLs, but including LWS>
 * LWS           = [CRLF] 1*( SP | HT )
 * CRLF          = CR LF
 * CR            = <US-ASCII CR, carriage return (13)>
 * LF            = <US-ASCII LF, linefeed (10)>
 * SP            = <US-ASCII SP, space (32)>
 * SHT           = <US-ASCII HT, horizontal-tab (9)>
 * CTL           = <any US-ASCII control character (octets 0 - 31) and DEL (127)>
 * OCTET         = <any 8-bit sequence of data>
 */
const PARAM_REG_EXP = '/; *([!#$%&\'*+.^_`|~0-9A-Za-z-]+) *= *("(?:[\x{000b}\x{0020}\x{0021}\x{0023}-\x{005b}\x{005d}-\x{007e}\x{0080}-\x{00ff}]|\\[\x{000b}\x{0020}-\x{00ff}])*"|[!#$%&\'*+.^_`|~0-9A-Za-z-]+) */u';
const TEXT_REG_EXP = '/^[\x{0020}-\x{007e}\x{0080}-\x{00ff}]+$/u';
const TOKEN_REG_EXP = '/^[!#$%\'\*\+\-\.0-9A-Z\^_`a-z\|~]+$/';

/**
 * RegExp to match quoted-pair in RFC 2616
 *
 * quoted-pair = "\" CHAR
 * CHAR        = <any US-ASCII character (octets 0 - 127)>
 */
const QESC_REG_EXP = '/\\([[:ascii:]])/';

/**
 * RegExp to match chars that must be quoted-pair in RFC 2616
 */
const QUOTE_REG_EXP = '/([\\"])/';

/**
 * RegExp to match type in RFC 6838
 *
 * type-name = restricted-name
 * subtype-name = restricted-name
 * restricted-name = restricted-name-first *126restricted-name-chars
 * restricted-name-first  = ALPHA / DIGIT
 * restricted-name-chars  = ALPHA / DIGIT / "!" / "#" /
 *                          "$" / "&" / "-" / "^" / "_"
 * restricted-name-chars =/ "." ; Characters before first dot always
 *                              ; specify a facet name
 * restricted-name-chars =/ "+" ; Characters after last plus always
 *                              ; specify a structured syntax suffix
 * ALPHA =  %x41-5A / %x61-7A   ; A-Z / a-z
 * DIGIT =  %x30-39             ; 0-9
 */
const SUBTYPE_NAME_REG_EXP = '/^[A-Za-z0-9][A-Za-z0-9!#$&^_.-]{0,126}$/';
const TYPE_NAME_REG_EXP = '/^[A-Za-z0-9][A-Za-z0-9!#$&^_-]{0,126}$/';
const TYPE_REG_EXP = '/^ *([A-Za-z0-9][A-Za-z0-9!#$&^_-]{0,126})\/([A-Za-z0-9][A-Za-z0-9!#$&^_.+-]{0,126}) *$/';


class MediaTyper
{

    public static function format(array $ar)
    {
        $subtype_flag = array_key_exists('subtype', $ar) && $ar['subtype'];
        $type_flag = array_key_exists('type', $ar) && $ar['type'];
        $suffix_flag = array_key_exists('suffix', $ar) && $ar['suffix'];
        $parameters_flag = array_key_exists('parameters', $ar) && $ar['parameters'];

        if (!$subtype_flag || !$type_flag) {
            $str_type = $subtype_flag === false ? 'invalid subtype' : 'invalid type';
            throw new \TypeError($str_type);
        }

        preg_match(TYPE_NAME_REG_EXP, $ar['subtype'], $subtype_matches);
        preg_match(SUBTYPE_NAME_REG_EXP, $ar['type'], $type_matches);

        $s_m_flag = !count($subtype_matches);
        $t_flag = !count($type_matches);

        if ($s_m_flag || $t_flag) {
            $str_m_type = $s_m_flag === true ? 'invalid subtype' : 'invalid type';
            throw new \TypeError($str_m_type);
        }

        $string = "{$ar['type']}/{$ar['subtype']}";

        if ($suffix_flag) {
            preg_match(TYPE_NAME_REG_EXP, $ar['suffix'], $suffix_matches);
            $sfx_flag = count($suffix_matches) !== 0;
        } else {
            $sfx_flag = false;
        }

        if ($suffix_flag) {
            if (!$sfx_flag) {
                throw new \TypeError('invalid suffix');
            }
            $string .= "+{$ar['suffix']}";
        }

        if ($parameters_flag && is_array($ar['parameters'])) {
            sort($ar['parameters']);
            $parameters = $ar['parameters'];

            foreach ($parameters as $parameter) {
                preg_match(TOKEN_REG_EXP, $parameter, $p_matches);
                if (count($p_matches) === 0) {
                    throw new \TypeError('invalid parameter name');
                }

                $quote_string = static::qstring($parameters[$parameter]);
                $string .= "; {$parameter}={$quote_string}";
            }
        }

        return $string;
    }

    /**
     * quote a string is necessary
     * @param string $val
     * @return string
     */
    private static function qstring(string $val)
    {
        preg_match(TOKEN_REG_EXP, $val, $matches);
        if (count($matches) > 0) {
            return $val;
        }

        preg_match(TEXT_REG_EXP, $val, $t_matches);
        if (strlen($val) > 0 && count($t_matches) === 0) {
            throw new \TypeError('invalid parameter value');
        }

        $replace_str = preg_replace(QUOTE_REG_EXP, '\\$1', $val);
        return "\"{$replace_str}\"";
    }

    /**
     * Simply "type/subtype+suffix" into parts
     * @param string $string
     * @return array
     */
    private static function splitType(string $string)
    {
        preg_match(TYPE_REG_EXP, strtolower($string), $matches);

        if (count($matches) === 0) {
            throw new \TypeError('invalid media type');
        }

        $type = $matches[1];
        $subtype = $matches[2];

        $index = strrpos($subtype, '+');
        $suffix = '';
        if ($index !== false) {
            $suffix = substr($subtype, $index + 1);
            $subtype = substr($subtype, 0, $index);
        }

        return [
            'type' => $type,
            'subtype' => $subtype,
            'suffix' => $suffix
        ];
    }

    public static function parse($string)
    {
        if (is_object($string)) {
            $string = self::getContentType($string);
        }

        if (is_string($string) === false) {
            throw new \TypeError('argument string is required to be a string');
        }

        $index = strpos($string, ';');
        $type = $index !== false ? substr($string, 0, $index) : $string;
        $params = [];

        $obj = self::splitType($type);

        $index_ = $index === false ? 0 : $index;
        preg_match_all(PARAM_REG_EXP, $string, $matches, PREG_OFFSET_CAPTURE, $index_);

        if (count($matches[0]) > 0) {
            if ($matches[0][0][1] !== $index) {
                throw new \TypeError('invalid parameter format');
            }

            $index += strlen($matches[0][0][0]);
            $key = strtolower($matches[1][0][0]);
            $value = $matches[2][0][0];

            if ($value[0] === '"') {
//                remove quotes and escapes
                $value = substr($value, 1, strlen($value) - 2);
                str_replace(QESC_REG_EXP, '$1', $value);
            }

            $params[$key] = $value;
        }

        if ($index !== false && $index !== strlen($string)) {
            throw new \TypeError('invalid parameter format');
        }

        $obj['parameters'] = $params;

        return $obj;
    }

    /**
     * Get content-type from req/res object
     * @param $obj
     * @return string
     */
    private static function getContentType($obj)
    {
        if ($obj instanceof Response) {
            return array_key_exists('content-type', $obj->header) ? $obj->header['content-type'] : '';
        }

        if ($obj instanceof Request) {
            return array_key_exists('content-type', $obj->headers) ? $obj->headers['content-type'] : '';
        }
    }
}