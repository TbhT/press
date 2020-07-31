<?php

namespace Press\Tests;

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

    /**
     * $res->etag
     */

    /** @test */
    public function shouldNotModifyAnEtagWithQuotes()
    {
        $res = $this->createRes();
        $res->etag = '"asdf"';
        $this->assertSame(['"asdf"'], $res->header['etag']);
    }

    /** @test */
    public function shouldNotModifyAWeakEtag()
    {
        $res = $this->createRes();
        $res->etag = 'W/"asdf"';
        $this->assertSame(['W/"asdf"'], $res->header['etag']);
    }

    /** @test */
    public function shouldAddQuotesAroundAnEtagIfNecessary()
    {
        $res = $this->createRes();
        $res->etag = 'asdf';
        $this->assertSame(['"asdf"'], $res->header['etag']);
    }

    /** @test */
    public function shouldReturnEtag()
    {
        $res = $this->createRes();
        $res->etag = '"asdf"';
        $this->assertSame('"asdf"', $res->etag);
    }

    /**
     * ctx->has()
     */

    /** @test */
    public function shouldCheckAFieldValueCaseInsensitiveWay()
    {
        $ctx = create();
        $ctx->set('X-Foo', '');
        $this->assertTrue($ctx->response->has('X-Foo'));
        $this->assertTrue($ctx->has('x-foo'));
    }

    /** @test */
    public function shouldReturnFalseForNonExistentHeader()
    {
        $ctx = create();
        $this->assertFalse($ctx->response->has('boo'));
        $ctx->set('x-foo', 5);
        $this->assertFalse($ctx->has('x-boo'));
    }

    /**
     * $ctx->header
     */

    /** @test */
    public function shouldReturnResponseHeaderObject()
    {
        $res = $this->createRes();
        $res->set('X-Foo', 'bar');
        $res->set('X-Number', 200);
        $this->assertSame(['x-foo' => ['bar'], 'x-number' => ['200']], $res->header);
    }

    /**
     * $ctx->is()
     */

    /** @test */
    public function shouldIgnoreParams()
    {
        $res = $this->createRes();
        $res->type = 'text/html; charset=utf-8';

        $this->assertSame('text/html', $res->is('text/*'));
    }

    /** @test */
    public function shouldReturnFalseWhenNoTypeIsSet()
    {
        $res = $this->createRes();
        $this->assertFalse($res->is());
        $this->assertFalse($res->is('html'));
    }

    /** @test */
    public function shouldReturnTypeWhenGivenNoTypes()
    {
        $res = $this->createRes();
        $res->type = 'text/html; charset=utf-8';

        $this->assertSame('text/html', $res->is());
    }

    /** @test */
    public function shouldReturnTypeOrFalseGivenOneType()
    {
        $res = $this->createRes();
        $res->type = 'image/png';

        $this->assertSame('png', $res->is('png'));
        $this->assertSame('.png', $res->is('.png'));
        $this->assertSame('image/png', $res->is('image/png'));
        $this->assertSame('image/png', $res->is('image/*'));
        $this->assertSame('image/png', $res->is('*/png'));

        array_map(function ($value) use ($res) {
            $this->assertFalse($res->is($value));
        }, [
            'jpeg',
            '.jpeg',
            'image/jpeg',
            'text/*',
            '*/jpeg'
        ]);
    }

    /** @test */
    public function shouldReturnFirstMatchOrFalseGivenMultipleTypes()
    {
        $res = $this->createRes();
        $res->type = 'image/png';

        array_map(function ($value) use ($res) {
            $this->assertSame('image/png', $res->is(...$value));
        }, [
            ['text/*', 'image/*'],
            ['image/*', 'text/*'],
            ['image/*', 'image/png'],
            ['image/png', 'image/*']
        ]);

        array_map(function ($value) use ($res) {
            $this->assertSame('image/png', $res->is($value));
        }, [
            ['text/*', 'image/*'],
            ['image/*', 'text/*'],
            ['image/*', 'image/png'],
            ['image/png', 'image/*']
        ]);

        array_map(function ($value) use ($res) {
            $this->assertFalse($res->is(...$value));
        }, [
            ['jpeg'],
            ['.jpeg'],
            ['text/*', 'application/*'],
            ['text/html', 'text/plain', 'application/json; charset=utf-8']
        ]);
    }

    /** @test */
    public function shouldMatchUrlencodedWhenContentTypeIs()
    {
        $res = $this->createRes();
        $res->type = 'application/x-www-form-urlencoded';

        $this->assertSame('urlencoded', $res->is('urlencoded'));
        $this->assertSame('urlencoded', $res->is('json', 'urlencoded'));
        $this->assertSame('urlencoded', $res->is('urlencoded', 'json'));
    }

    /**
     * $res->lastModified
     */

    private function createUTCTime()
    {
        return gmdate('Y-m-d H:i:s');
    }

    /** @test */
    public function shouldSetHeaderAsUTCString()
    {
        $res = $this->createRes();
        $date = $this->createUTCTime();
        $res->lastModified = $date;

        $this->assertSame([$date], $res->header['last-modified']);
        $this->assertSame($date, $res->lastModified);
    }

    /**
     * $res->message
     */

    /** @test */
    public function shouldReturnResponseStatusMessage()
    {
        $res = $this->createRes();
        $res->status = 200;
        $this->assertSame('OK', $res->message);
    }

    /** @test */
    public function shouldSetResponseStatusMessage()
    {
        $res = $this->createRes();
        $res->status = 200;
        $res->message = 'ok';
        $this->assertSame('ok', $res->message);
    }

    /**
     * $ctx->remove()
     */

    /** @test */
    public function shouldRemoveAField()
    {
        $ctx = create();
        $ctx->set('x-foo', 'bar');
        $ctx->remove('x-foo');

        $this->assertSame([], $ctx->response->header);
    }


    /**
     * ctx->set()
     */

    /** @test */
    public function shouldSetFieldValue()
    {
        $ctx = create();
        $ctx->set('x-foo', 'bar');
        $this->assertSame(['bar'], $ctx->response->header['x-foo']);
    }

    /** @test */
    public function shouldCoerceNumberToString()
    {
        $ctx = create();
        $ctx->set('x-foo', 5);
        $this->assertSame(['5'], $ctx->response->header['x-foo']);
    }

    /** @test */
    public function shouldSetAFieldValueOfArray()
    {
        $ctx = create();
        $ctx->set('x-foo', ['foo', 'bar', 123]);
        $this->assertSame(['foo', 'bar', '123'], $ctx->response->header['x-foo']);
    }

    /** @test */
    public function shouldSetMultipleFields()
    {
        $this->markTestIncomplete('todo');
        $ctx = create();
        $ctx->set([
            'foo' => '1',
            'bar' => '2'
        ]);

        $this->assertSame('1', $ctx->response->header['foo']);
        $this->assertSame('2', $ctx->response->header['bar']);
    }

    /**
     * $res->length
     */

    /** @test */
    public function shouldReturnANumberWhenContentLengthIsDefined()
    {
        $res = $this->createRes();
        $res->set('Content-Length', '1024');
        $this->assertSame(1024, $res->length);
    }

    /** @test */
    public function shouldReturnOWhenLengthIsNotNumber()
    {
        $res = $this->createRes();
        $res->set('Content-Length', 'hey');
        $this->assertSame(0, $res->length);
    }

    /** @test */
    public function shouldReturnANumberWhenContentLengthIsNotDefined()
    {
        $res = $this->createRes();

        $res->body = 'foo';
        $res->remove('Content-Length');
        $this->assertSame(3, $res->length);

        $res->body = 'foo';
        $this->assertSame(3, $res->length);

        $res->body = stream_for('foo bar');
        $res->remove('Content-Length');
        $this->assertSame(7, $res->length);

        $res->body = stream_for('foo bar');
        $this->assertSame(7, $res->length);

        $obj = new stdClass();
        $obj->hello = 'world';
        $res->body = $obj;
        $res->remove('Content-Length');
        $this->assertSame(17, $res->length);

        $res->body = $obj;
        $this->assertSame(17, $res->length);

        $res->body = null;
        $this->assertSame(0, $res->length);
    }

    /**
     * $ctx->vary()
     */

    /** @test */
    public function shouldSetItWhenVaryNotSet()
    {
        $ctx = create();
        $ctx->vary('Accept');

        $this->assertSame(['Accept'], $ctx->response->header['vary']);
    }

    /** @test */
    public function shouldAppendWhenVaryIsSet()
    {
        $ctx = create();
        $ctx->vary('Accept');
        $ctx->vary('Accept-Encoding');
        $this->assertSame(['Accept, Accept-Encoding'], $ctx->response->header['vary']);
    }

    /** @test */
    public function shouldNotAppendWhenVaryAlreadyContainsValue()
    {
        $ctx = create();
        $ctx->vary('Accept');
        $ctx->vary('Accept-Encoding');
        $ctx->vary('Accept');
        $ctx->vary('Accept-Encoding');
        $this->assertSame(['Accept, Accept-Encoding'], $ctx->response->header['vary']);
    }
}
