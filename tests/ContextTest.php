<?php

namespace Press\Tests;

use Press\Context;
use PHPUnit\Framework\TestCase;
use function Press\Tests\Context\create;

class ContextTest extends TestCase
{
    /** @test */
    public function acceptShouldReturnInstance()
    {
        $ctx = create();
        $headers = [
            'accept' => 'application/*;q=0.2, image/jpeg;q=0.8, text/html, text/plain'
        ];
        $ctx->request->header = $headers;
        $this->assertTrue($ctx instanceof Context);
    }

    /** @test */
    public function acceptAssignShouldBeReplaced()
    {
        $ctx = create();
        $headers = [
            'accept' => 'text/plain'
        ];
        $ctx->request->header = $headers;
        $this->assertSame(['text/plain'], $ctx->accepts());
    }
}
