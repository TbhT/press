<?php

namespace Press\Tests\Utils;

use Press\Utils\Delegates;
use PHPUnit\Framework\TestCase;
use stdClass;

class DelegatesTest extends TestCase
{
    /** @test */
    public function shouldDelegateMethods()
    {
        $obj = new stdClass();
        $obj->request = new stdClass();

        $obj->request->foo = function ($bar) {
            return $bar;
        };

        $delegate = new Delegates($obj, 'request');
        $delegate->method('foo');

        $this->assertSame(call_user_func_array($obj->foo, ['press']), 'press');
    }

    /** @test */
    public function shouldDelegateGetters()
    {
        $obj = new stdClass();
        $obj->request = new stdClass();
        $obj->request->type = 'text/html';

        $delegate = new Delegates($obj, 'request');
        $delegate->getter('type');

        $this->assertSame($obj->type, 'text/html');
    }

    /** @test */
    public function shouldDelegateInFluentFashion()
    {
        $obj = new stdClass();
        $obj->settings = new stdClass();
        $obj->settings->env = 'development';

        $delegate = new Delegates($obj, 'settings');
        $delegate->fluent('env');

        $this->assertSame(($obj->env)(), 'development');
        ($obj->env)('production');
        $this->assertSame($obj->settings->env, 'production');
    }
}
