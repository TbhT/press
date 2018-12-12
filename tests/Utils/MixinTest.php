<?php

use Press\Helper\Mixin;
use PHPUnit\Framework\TestCase;


class MixinTest extends TestCase
{
    public function testOne()
    {
        $req = new \Swoole\Http\Request();
        $req->app = new Press\Press();
        Mixin::request($req);

    }
}
