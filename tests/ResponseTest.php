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

    /** @test */
    public function shouldOverrideLength()
    {
        $res = $this->createRes();

        $res->type = 'html';
        $res->body = 'something';
        $this->assertSame(9, $res->length);
    }

    /** @test */
    public function shouldDefaultToTextWhenStringGiven()
    {
        $res = $this->createRes();
        $res->body = 'Tobi';
        $this->assertSame('text/plain; charset=utf-8', $res->get('content-type'));
    }

    /** @test */
    public function shouldSetLengthWhenStringGiven()
    {
        $res = $this->createRes();
        $res->body = 'Tobi';
        $this->assertSame('4', $res->get('content-length'));
    }

    /** @test */
    public function shouldDefaultToTextWhenStringGivenAndNonLeading()
    {
        $res = $this->createRes();
        $res->body = 'aklsdjf < klajsdlfjasd';
        $this->assertSame('text/plain; charset=utf-8', $res->get('content-type'));
    }

    /** @test */
    public function shouldDefaultToHtmlWhenHtmlStringGiven()
    {
        $res = $this->createRes();
        $res->body = '<h1>Tobi</h1>';
        $this->assertSame('text/html; charset=utf-8', $res->get('content-type'));
    }

    /** @test */
    public function shouldSetLengthWhenBodyOverridden()
    {
        $res = $this->createRes();
        $string = '<h1>Tobi</h1>';
        $res->body = $string;
        $res->body = $string . $string;
        $this->assertSame(strlen($res->body), strlen($string) * 2);
    }

    /** @test */
    public function shouldDefaultToHtmlWhenLeadingContainsWhitespace()
    {
        $res = $this->createRes();
        $res->body = '    <h1>Tobi</h1>';
        $this->assertSame('text/html; charset=utf-8', $res->get('content-type'));
    }

    /** @test */
    public function shouldDefaultToHtmlWhenXMLGive()
    {
        $res = $this->createRes();
        $res->body = '<?xml version="1.0" encoding="UTF-8"?>\n<俄语>данные</俄语>';
        $this->assertSame('text/html; charset=utf-8', $res->get('content-type'));
    }

    /** @test */
    public function shouldDefaultToStreamWhenStreamGiven()
    {
        $res = $this->createRes();
        $res->body = stream_for('hello');
        $this->assertSame('application/octet-stream', $res->get('content-type'));
    }

    /** @test */
    public function shouldAddErrorHandler()
    {
        $this->markTestSkipped('todo add error handler');
    }

    /** @test */
    public function shouldDefaultToJSONWhenObjectGiven()
    {
        $res = $this->createRes();
        $result = new stdClass();
        $result->foo = 'bar';
        $res->body = $result;
        $this->assertSame('application/json; charset=utf-8', $res->get('content-type'));
    }
}
