<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 上午9:25
 */

namespace Press\Utils;

use Press\Request;
use Press\Utils\Negotiator;
use Press\Utils\Mime;


class Accepts
{
    private $headers;
    private $negotiator;

    public function __construct(Request $req)
    {
        $this->headers = $req->headers;
        $this->negotiator = new Negotiator\Negotiator($req);
    }

    private function _type($types, array $args)
    {
//      support flattened arguments
        if ($types && is_array($types) === false) {
            $args_ = [];
            foreach ($args as $key => $arg) {
                $args_[$key] = $arg;
            }
        }

//      no types, return all requested types
        if (!$types || count($types) === 0) {
            return $this->negotiator->mediaTypes();
        }

        if (array_key_exists('accept', $this->headers) === false) return $types[0];
        $mimes = array_map(self::extToMime(), $types);
        $mimes = array_filter($mimes, self::validMime());
        $accepts = $this->negotiator->mediaTypes($mimes);
        if (empty($accepts)) return false;

        $index = array_search($accepts[0], $mimes);
        return $types[$index];
    }

    public function type($types)
    {
        $args = func_get_args();
        return $this->_type($types, $args);
    }

    public function types($types)
    {
        $args = func_get_args();
        return $this->_type($types, $args);
    }

    private static function extToMime()
    {
        return function (string $type) {
            return strpos($type, '/') === false ? Mime\MimeTypes::lookup($type) : $type;
        };
    }

    private static function validMime()
    {
        return function (string $type) {
            return is_string($type);
        };
    }


    private function _encoding($encodings, $args)
    {
//      support flattened arguments
        if ($encodings && is_array($encodings) === false) {
            $args_ = [];
            foreach ($args as $key => $arg) {
                $args_[$key] = $arg;
            }
        }

        // no encodings, return all requested encodings
        if (!$encodings || count($encodings) === 0) {
            return $this->negotiator->encodings();
        }

        $_encodings = $this->negotiator->encodings($encodings);
        return $_encodings[0] || false;
    }

    public function encoding($encodings)
    {
        $args = func_get_args();
        return $this->_encoding($encodings, $args);
    }

    public function encodings($encodings)
    {
        $args = func_get_args();
        return $this->_encoding($encodings, $args);
    }


    private function _charset($charsets, $args)
    {
        //      support flattened arguments
        if ($charsets && is_array($charsets) === false) {
            $args_ = [];
            foreach ($args as $key => $arg) {
                $args_[$key] = $arg;
            }
        }

        // no charsets, return all requested charsets
        if ($charsets || count($charsets) === 0) {
            return $this->negotiator->charsets();
        }

        $_charsets = $this->negotiator->charsets($charsets);
        return $_charsets[0] || false;
    }

    public function charsets($charsets)
    {
        $args = func_get_args();
        return $this->_charset($charsets, $args);
    }

    public function charset($charsets)
    {
        $args = func_get_args();
        return $this->_charset($charsets, $args);
    }


    private function _language($languages, $args)
    {
        //      support flattened arguments
        if ($languages && is_array($languages) === false) {
            $args_ = [];
            foreach ($args as $key => $arg) {
                $args_[$key] = $arg;
            }
        }

        // no languages, return all requested languages
        if (!$languages || count($languages) === 0) {
            return $this->negotiator->languages();
        }

        $_language = $this->negotiator->languages();

        return $_language[0] || false;
    }

    public function language($languages)
    {
        $args = func_get_args();
        return $this->_language($languages, $args);
    }

    public function lang($languages)
    {
        $args = func_get_args();
        return $this->_language($languages, $args);
    }

    public function langs($languages)
    {
        $args = func_get_args();
        return $this->_language($languages, $args);
    }

    public function languages($languages)
    {
        $args = func_get_args();
        return $this->_language($languages, $args);
    }
}