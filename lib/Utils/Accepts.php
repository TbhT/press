<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 上午9:25
 */

namespace Press\Utils;

use function foo\func;
use Press\Request;
use Press\Utils\Negotiator;
use Press\Utils\Mime;


/**
 * convert extnames to mime
 * @return \Closure
 */
function ext_to_mime()
{
    return function ($type) {
        return strpos($type, '/') === false ?
            Mime\MimeTypes::lookup($type) : $type;
    };
}


/**
 * @return \Closure
 */
function valid_mime()
{
    return function ($type) {
        return is_string($type);
    };
}


class Accepts
{
    private $headers;
    private $negotiator;

    public function __construct(Request $req)
    {
        $this->headers = $req->headers;
        $this->negotiator = new Negotiator\Negotiator($req);
    }

    private function type_($args, $types)
    {
        // support flattened arguments
        if ($types && !is_array($types)) {
            $types = $args;
        }

        // no types, return all requested types
        if (!$types || count($types) === 0) {
            return $this->negotiator->mediaTypes();
        }

        if (array_key_exists('accept', $this->headers) === false) {
            return $types[0];
        }

        $mime = array_map(ext_to_mime(), $types);
        $mime = array_filter($mime, valid_mime());
        $accepts = $this->negotiator->mediaTypes($mime);

        if (count($accepts) === 0 || !$accepts[0]) {
            return false;
        }

        $index = array_search($accepts[0], $mime);
        return $types[$index];
    }

    public function type($types_ = null)
    {
        $args = func_get_args();
        return self::type_($args, $types_);
    }

    public function types($types_ = null)
    {
        $args = func_get_args();
        return self::type_($args, $types_);
    }

    private function encoding_($args, $encodings_)
    {
        // support flattened arguments
        if ($encodings_ && !is_array($encodings_)) {
            $encodings_ = $args;
        }

        // no encodings, return all requested encodings
        if (!$encodings_ || count($encodings_) === 0) {
            return $this->negotiator->encodings();
        }

        $encoding = $this->negotiator->encodings($encodings_);
        $result = empty($encoding) ? false : $encoding[0];
        return $result;
    }


    public function encoding($encodings_ = null)
    {
        $args = func_get_args();
        return $this->encoding_($args, $encodings_);
    }


    public function encodings($encodings_ = null)
    {
        $args = func_get_args();
        return $this->encoding_($args, $encodings_);
    }


    private function charset_($args, $charsets_)
    {
        // support flattend arguments
        if ($charsets_ && !is_array($charsets_)) {
            $charsets_ = $args;
        }

        // no charsets, returned all requested charsets
        if (!$charsets_ || count($charsets_) === 0) {
            return $this->negotiator->charsets();
        }

        $charset = $this->negotiator->charsets($charsets_);
        $result = empty($charset) ? false : $charset[0];
        return $result;
    }


    public function charset($charsets_ = null)
    {
        $args = func_get_args();
        return $this->charset_($args, $charsets_);
    }


    public function charsets($charsets_ = null)
    {
        $args = func_get_args();
        return $this->charset_($args, $charsets_);
    }


    private function language_($args, $languages_)
    {
        // support flattened arguments
        if ($args && !is_array($languages_)) {
            $languages_ = $args;
        }

        // no languages, return all requested languages
        if (!$languages_ || count($languages_) === 0) {
            return $this->negotiator->languages();
        }

        $language = $this->negotiator->languages($languages_);
        $result = empty($language) ? false : $language[0];
        return $result;
    }


    public function lang($languages_ = null)
    {
        $args = func_get_args();
        return $this->language_($args, $languages_);
    }


    public function langs($languages_ = null)
    {
        $args = func_get_args();
        return $this->language_($args, $languages_);
    }


    public function language($languages_ = null)
    {
        $args = func_get_args();
        return $this->language_($args, $languages_);
    }


    public function languages($languages_ = null)
    {
        $args = func_get_args();
        return $this->language_($args, $languages_);
    }
}