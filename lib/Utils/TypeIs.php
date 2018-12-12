<?php
declare(strict_types=1);


namespace Press\Utils;

use Swoole\Http\Request;
use Press\Utils\Mime\MimeTypes;


class TypeIs
{
    /**
     * Compare a `value` content-type with `types`.
     * Each `type` can be an extension like `html`,
     * a special shortcut like `multipart` or `urlencoded`,
     * or a mime type.
     *
     * If no types match, `false` is returned.
     * Otherwise, the first `type` that matches is returned.
     * @param $value
     * @param $types_
     * @return bool|mixed|null
     */
    private static function typeIs($value, $types_ = null)
    {
        // remove parameters and normalize
        $val = self::tryNormalizeType($value);

        // no type or invalid
        if (!$val) {
            return false;
        }

        // support flattened arguments
        if ($types_ && !is_array($types_)) {
            $args = func_get_args();
            $flatten_length = count($args) - 1;
            $types_ = [];
            for ($i = 0; $i < $flatten_length; ++$i) {
                $types_[$i] = $args[$i + 1];
            }
        }

        // no types, return the content type
        if (!$types_ || (is_array($types_) && !count($types_))) {
            return $val;
        }

        for ($i = 0; $i < count($types_); $i++) {
            $type = $types_[$i];
            $normalize_val = self::normalize($type);
            if (self::mimeMatch($normalize_val, $val)) {
                return $type[0] === '+' || strpos($type, '*') !== false ? $val : $type;
            }
        }

        // no matches
        return false;
    }

    public static function is($value, $type_)
    {
        return self::typeIs($value, $type_);
    }

    /**
     * Check if the incoming request contains the "Content-Type"
     * header field, and it contains any of the give mime `type`s.
     * If there is no request body, `null` is returned.
     * If there is no content type, `false` is returned.
     * Otherwise, it returns the first `type` that matches.
     * @param Request $req
     * @param $types_
     * @return null
     */
    public static function typeOfRequest(Request $req, $types_ = null)
    {
        if (!self::hasBody($req)) {
            return null;
        }

        $args = func_get_args();
        if (count($args) > 2) {
            $types_ = [];
            for ($i = 0; $i < count($args) - 1; $i++) {
                $types_[$i] = $args[$i + 1];
            }
        }

        // request content type
        $value = $req->header['content-type'];

        return self::typeIs($value, $types_);
    }

    /**
     * check if a request has request body
     * @param Request $req
     * @return bool
     */
    public static function hasBody(Request $req)
    {
        return array_key_exists('transfer-encoding', $req->header) || array_key_exists('content-length', $req->header);
    }

    /**
     * Try to normalize a type and remove parameters.
     * @param $value
     * @return null
     */
    private static function tryNormalizeType($value)
    {
        try {
            return self::normalizeType($value);
        } catch (\Error $exception) {
            return null;
        }
    }

    /**
     * Normalize a type and remove parameters.
     * @param $value
     * @return string
     */
    public static function normalizeType($value)
    {
        if (is_string($value) === false) {
            return false;
        }

        // parse the type
        $type = MediaTyper::parse($value);

        // remove the parameters
        $type['parameters'] = null;

        // reformat it
        return MediaTyper::format($type);
    }

    private static function match($expected, $actual)
    {
        return self::mimeMatch($expected, $actual);
    }

    /**
     * Check if `expected` mime type
     * matches `actual` mime type with
     * wildcard and +suffix support.
     * @param string $expected
     * @param string $actual
     * @return bool
     */
    private static function mimeMatch($expected, $actual)
    {
        // invalid type
        if ($expected === false) {
            return false;
        }

        // split types
        $actualParts = explode('/', $actual);
        $expectedParts = explode('/', $expected);

        // invalid format
        if (count($actualParts) !== 2 || count($expectedParts) !== 2) {
            return false;
        }

        // validate type
        if ($expectedParts[0] !== '*' && $expectedParts[0] !== $actualParts[0]) {
            return false;
        }

        // validate suffix wildcard
        if (substr($expectedParts[1], 0, 2) === '*+') {
            return strlen($expectedParts[1]) <= (strlen($actualParts[1]) + 1) &&
                substr($expectedParts[1], 1) === substr($actualParts[1], 1 - strlen($expectedParts[1]));
        }

        // validate subtype
        if ($expectedParts[1] !== '*' && $expectedParts[1] !== $actualParts[1]) {
            return false;
        }

        return true;
    }

    public static function normalize($type)
    {
        if (is_string($type) === false) {
            return false;
        }

        switch ($type) {
            case 'urlencoded':
                return 'application/x-www-form-urlencoded';
            case 'multipart':
                return 'multipart/*';
        }

        if ($type[0] === '+') {
            // "+json" -> "*/*+json" expando
            return '*/*' . $type;
        }

        return strpos($type, '/') === false ? MimeTypes::lookup($type) : $type;
    }
}