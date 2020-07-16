<?php

namespace Press\Tests;

use Press\Context;
use PHPUnit\Framework\TestCase;
use function Press\Tests\Context\create;

class RequestTest extends TestCase
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

    /** @test */
    public function acceptsWithNoArguments()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept' => 'application/*;q=0.2, image/jpeg;q=0.8, text/html, text/plain'
        ];

        $this->assertSame(['text/html', 'text/plain', 'image/jpeg', 'application/*'], $ctx->accepts());
    }

    /** @test */
    public function acceptWithNoValidTypesWhenAcceptIsPopulated()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept' => 'application/*;q=0.2, image/jpeg;q=0.8, text/html, text/plain'
        ];

        $result = $ctx->accepts('image/png', 'image/tiff');
        $this->assertSame(false, $result);
    }

    /** @test */
    public function acceptWithNoValidTypesWhenAcceptIsNotPopulated()
    {
        $ctx = create();

        $result = $ctx->accepts('text/html', 'text/plain', 'image/jpeg', 'application/*');
        $this->assertSame('text/html', $result);
    }

    /** @test */
    public function shouldConvertToMimeTypesWhenExtensionsAreGiven()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept' => 'text/plain, text/html'
        ];

        $this->assertSame('html', $ctx->accepts('html'));
        $this->assertSame('.html', $ctx->accepts('.html'));
        $this->assertSame('txt', $ctx->accepts('txt'));
        $this->assertSame('.txt', $ctx->accepts('.txt'));
        $this->assertSame(false, $ctx->accepts('png'));
    }

    /** @test */
    public function shouldReturnFirstMatchWhenArrayIsGiven()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept' => 'text/plain, text/html'
        ];

        $this->assertSame('text', $ctx->accepts('text/html'));
        $this->assertSame('html', $ctx->accepts('png', 'html'));
    }
}
