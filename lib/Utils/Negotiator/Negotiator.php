<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 上午9:58
 */

namespace Press\Utils\Negotiator;


class Negotiator
{

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }


    public function charsets($available)
    {
        return Charset::preferredCharsets($this->request->headers['accept-charset'], $available);
    }


    public function charset($available)
    {
        $set = $this->charsets($available);
        return $set && $set[0];
    }


    public function encoding($available)
    {
        $set = $this->charsets($available);
        return $set && $set[0];
    }


    public function encodings($available)
    {
        return Encoding::prefferedEncodings($this->request->headers['accept-encoding'], $available);
    }


    public function language($available)
    {
        $set = Language::prefferedLanguage($this->request->headers['accept-language'], $available);
        return $set && $set[0];
    }


    public function languages($available)
    {
        return $this->language($available);
    }


    public function mediaType($available)
    {
        $set = $this->mediaTypes($available);
        return $set && $set[0];
    }


    public function mediaTypes($available)
    {
        return MediaType::preferredMediaTypes($this->request->headers['mediaType'], $available);
    }
}