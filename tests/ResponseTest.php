<?php

namespace Press\Tests;

use Press\Response;
use PHPUnit\Framework\TestCase;
use stdClass;
use function Press\Tests\Context\create;
use function RingCentral\Psr7\stream_for;

class ResponseTest extends TestCase
{
    private function createRes()
    {
        return create()->response;
    }

    /** @test */
    public function shouldNotOverrideWhenContentTypeIsSet()
    {
        $res = $this->createRes();
        $res->type = 'png';
        $res->body = ('something');

        $this->assertSame('image/png', $res->get('content-type'));
    }

    /** @test */
    public function shouldOverrideAsJsonWhenBodyIsArray()
    {
        $res = $this->createRes();

        $res->body = '<em>hey</em>';
        $this->assertSame('text/html; charset=utf-8', $res->get('content-type'));

        $obj = new stdClass();
        $obj->foo = 'bar';

        $res->body = $obj;
        $this->assertSame('application/json; charset=utf-8', $res->get('content-type'));
    }
}
