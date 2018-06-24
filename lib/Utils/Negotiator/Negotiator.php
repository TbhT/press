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
        $set = Charset::preferredCharsets($this->request->headers['accept-charset'], $available);
        return $set && $set[0];
    }


    public function encoding($available)
    {
        $set = Encoding::prefferedEncodings($this->request->headers['accept-encoding'], $available);
        return $set && $set[0];
    }


    public function encodings($available)
    {
        return Encoding::prefferedEncodings($this->request->headers['accept-encoding'], $available);
    }


    public function language($available)
    {

    }


    public function languages($available)
    {

    }


    public function mediaTypes($available)
    {

    }
}