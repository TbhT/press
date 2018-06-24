<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 上午9:58
 */

namespace Press\Utils\Negotiator;

use Press\Utils\Negotiator\Charset;


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

    }


    public function encodings($available)
    {

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