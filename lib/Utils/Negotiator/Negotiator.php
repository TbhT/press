<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 上午9:58
 */

namespace Press\Utils\Negotiator;

use Press\Request;


class Negotiator
{

    public $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function charsets($available = null)
    {
        $accept_charset = array_key_exists('accept-charset', $this->request->headers) ?
            $this->request->headers['accept-charset'] : '';
        $accept_charset = empty($accept_charset) ? '' : $accept_charset;
        return Charset::preferredCharsets($accept_charset, $available);
    }


    public function charset($available = null)
    {
        $set = $this->charsets($available);
        return empty($set) ? null : $set[0];
    }


    public function encoding($available = null)
    {
        $set = $this->encodings($available);
        return empty($set) ? null : $set[0];
    }


    public function encodings($available = null)
    {
        $accept_encoding = array_key_exists('accept-encoding', $this->request->headers) ?
            $this->request->headers['accept-encoding'] : '';
        $accept_encoding = empty($accept_encoding) ? '' : $accept_encoding;
        return Encoding::preferredEncodings($accept_encoding, $available);
    }


    public function language($available = null)
    {
        $set = Language::preferredLanguage($this->request->headers['accept-language'], $available);
        return empty($set) ? null : $set[0];
    }


    public function languages($available = null)
    {
        return $this->language($available);
    }


    public function mediaType($available = null)
    {
        $set = $this->mediaTypes($available);
        return empty($set) ? null : $set[0];
    }


    public function mediaTypes($available = null)
    {
        return MediaType::preferredMediaTypes($this->request->headers['mediaType'], $available);
    }
}