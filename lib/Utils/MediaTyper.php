<?php


namespace Press\Utils;


class MediaTyper
{
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
    private $paramRegExp = '/; *([!#$%\'\*\+\-\.0-9A-Z\^_`a-z\|~]+) *= *("(?:[ !\u0023-\u005b\u005d-\u007e\u0080-\u00ff]|\\[\u0020-\u007e])*"|[!#$%\'\*\+\-\.0-9A-Z\^_`a-z\|~]) */g';
    private $textRegExp = '/^[\u0020-\u007e\u0080-\u00ff]+$/';
    private $tokenRegExp = '/^[!#$%\'\*\+\-\.0-9A-Z\^_`a-z\|~]+$/';

    /**
     * RegExp to match quoted-pair in RFC 2616
     *
     * quoted-pair = "\" CHAR
     * CHAR        = <any US-ASCII character (octets 0 - 127)>
     */
    private $qescRegExp = '/\\([\u0000-\u007f])/g';

    /**
     * RegExp to match chars that must be quoted-pair in RFC 2616
     */
    private $quoteRegExp = '/([\\"])/g';

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
    private $subtypeNameRegExp = '/^[A-Za-z0-9][A-Za-z0-9!#$&^_.-]{0,126}$/';
    private $typeNameRegExp = '/^[A-Za-z0-9][A-Za-z0-9!#$&^_-]{0,126}$/';
    private $typeRegExp = '/^ *([A-Za-z0-9][A-Za-z0-9!#$&^_-]{0,126})\/([A-Za-z0-9][A-Za-z0-9!#$&^_.+-]{0,126}) *$/';
}