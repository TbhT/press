<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 上午9:25
 */

namespace Press\Util;

use Press\Request;


class Accepts
{
    private $headers;

    public function __construct(Request $req)
    {
        $this->headers = $req->headers;
    }


}