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
        return Charset::preferredCharsets($this->request->headers['accept-charset'], $available);
    }


    public function charset($available = null)
    {
        $set = $this->charsets($available);
        return $set && $set[0];
    }


    public function encoding($available = null)
    {
        $set = $this->charsets($available);
        return $set && $set[0];
    }


    public function encodings($available = null)
    {
        return Encoding::prefferedEncodings($this->request->headers['accept-encoding'], $available);
    }


    public function language($available = null)
    {
        $set = Language::prefferedLanguage($this->request->headers['accept-language'], $available);
        return $set && $set[0];
    }


    public function languages($available = null)
    {
        return $this->language($available);
    }


    public function mediaType($available = null)
    {
        $set = $this->mediaTypes($available);
        return $set && $set[0];
    }


    public function mediaTypes($available = null)
    {
        return MediaType::preferredMediaTypes($this->request->headers['mediaType'], $available);
    }
}