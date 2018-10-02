<?php
declare(strict_types=1);

namespace Press\Utils;

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

const PARAM_REG_EXP = '/; *([!#$%&\'*+.^_`|~0-9A-Za-z-]+) *= *("(?:[\x{000b}\x{0020}\x{0021}\x{0023}-\x{005b}\x{005d}-\x{007e}\x{0080}-\x{00ff}]|\\[\x{000b}\x{0020}-\x{00ff}])*"|[!#$%&\'*+.^_`|~0-9A-Za-z-]+) */u';
const TEXT_REG_EXP = '/^[\x{000b}\x{0020}-\x{007e}\x{0080}-\x{00ff}]+$/u';
const TOKEN_REG_EXP = '/^[!#$%&\'*+.^_`|~0-9A-Za-z-]+$/u';

const QESC_REG_EXP = '/\\([\u000b\u0020-\u00ff])/';

const QUOTE_REG_EXP = '/([\\"])/';

const TYPE_REG_EXP = '/^[!#$%&\'*+.^_`|~0-9A-Za-z-]+\/[!#$%&\'*+.^_`|~0-9A-Za-z-]+$/';


class ContentType
{
    public static function format(array $t)
    {
        $t = empty($t) ? [
            'parameters' => null,
            'type' => ''
        ] : $t;

        $parameters = $t['parameters'];
        $type = $t['type'];

        preg_match(TYPE_REG_EXP, $type,$m);

        if (!$type || count($m) === 0) {
            throw new \TypeError('invalid type');
        }

        // append parameters
        if (!empty($parameters) && gettype($parameters) === 'array') {

        }
    }

    public static function parse()
    {

    }


}