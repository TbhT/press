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

        $this->assertSame('text', $ctx->accepts(['png', 'text', 'html']));
        $this->assertSame('html', $ctx->accepts(['png', 'html']));
    }

    /** @test */
    public function shouldReturnFirstMatchWhenMultiArgumentsGiven()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept' => 'text/plain, text/html'
        ];

        $this->assertSame('text', $ctx->accepts('png', 'text', 'html'));
        $this->assertSame('html', $ctx->accepts('png', 'html'));
    }

    /** @test */
    public function shouldReturnTheTypeWhenPresentInExactMatch()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept' => 'text/plain, text/html'
        ];

        $this->assertSame('text/html', $ctx->accepts('text/html'));
        $this->assertSame('text/plain', $ctx->accepts('text/plain'));
    }

    /** @test */
    public function shouldReturnTypeWhenPresentAsASubtypeMatch()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept' => 'application/json, text/*'
        ];

        $this->assertSame('text/html', $ctx->accepts('text/html'));
        $this->assertSame('text/plain', $ctx->accepts('text/plain'));
        $this->assertSame(false, $ctx->accepts('image/png'));
        $this->assertSame(false, $ctx->accepts('png'));
    }

    /** @test */
    public function shouldReturnAcceptTypesWhenAcceptCharsetPopulated()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-charset' => 'utf-8, iso-8859-1;q=0.2, utf-7;q=0.5'
        ];

        $this->assertSame(['utf-8', 'utf-7', 'iso-8859-1'], $ctx->acceptsCharsets());
    }

    /** @test */
    public function shouldReturnBestFitIfAnyTypesMatch()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-charset' => 'utf-8, iso-8859-1;q=0.2, utf-7;q=0.5'
        ];

        $this->assertSame('utf-8', $ctx->acceptsCharsets('utf-7', 'utf-8'));
    }

    /** @test */
    public function shouldReturnFalseIfNoTypesMatch()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-charset' => 'utf-8, iso-8859-1;q=0.2, utf-7;q=0.5'
        ];

        $this->assertSame(false, $ctx->acceptsCharsets('utf-16'));
    }

    /** @test */
    public function shouldReturnFirstTypeWhenAcceptsCharsetNotPopulated()
    {
        $ctx = create();
        $this->assertSame('utf-7', $ctx->acceptsCharsets('utf-7', 'utf-8'));
    }

    /** @test */
    public function shouldReturnBestFitWithArray()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-charset' => 'utf-8, iso-8859-1;q=0.2, utf-7;q=0.5'
        ];

        $this->assertSame('utf-8', $ctx->acceptsCharsets('utf-7', 'utf-8'));
    }

    private function createRequest()
    {
        return create()->request;
    }

    /** @test */
    public function shouldReturnEmptyStringWithNoContentType()
    {
        $req = $this->createRequest();
        $this->assertSame('', $req->charset);
    }


    /** @test */
    public function shouldReturnEmptyStringWithCharsetPresent()
    {
        $req = $this->createRequest();
        $req->headers = [
            'content-type' => 'text/plain'
        ];
        $this->assertSame('', $req->charset);
    }

    /** @test */
    public function shouldReturnCharsetWithCharsetPresent()
    {
        $req = $this->createRequest();
        $req->headers = [
            'content-type' => 'text/plain; charset=utf-8'
        ];

        $this->assertSame('utf-8', $req->charset);
    }

    /** @test */
    public function shouldReturnEmptyStringWhenContentTypeInvalid()
    {
        $req = $this->createRequest();
        $req->headers = [
            'content-type' => 'application/json; application/text; charset=utf-8'
        ];

        $this->assertSame('', $req->charset);
    }

}
