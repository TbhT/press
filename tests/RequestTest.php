<?php

namespace Press\Tests;

use http\Env\Response;
use Press\Application;
use Press\Context;
use PHPUnit\Framework\TestCase;
use React\Http\Client\RequestData;
use RingCentral\Psr7\ServerRequest;
use function Press\Tests\Context\create;
use function Press\Tests\Context\createAll;
use function Press\Tests\Context\createWithReqOpt;

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

    /** @test */
    public function shouldReturnAcceptTypeWhenAcceptEncodingPopulated()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-encoding' => 'gzip, compress;q=0.2'
        ];

        $this->assertSame(['gzip', 'compress', 'identity'], $ctx->acceptsEncodings());
        $this->assertSame('gzip', $ctx->acceptsEncodings('gzip', 'compress'));
    }

    /** @test */
    public function shouldReturnIdentityWhenAcceptEncodingNotPopulated()
    {
        $ctx = create();
        $this->assertSame(['identity'], $ctx->acceptsEncodings());
        $this->assertSame('identity', $ctx->acceptsEncodings('gzip', 'deflate', 'identity'));
    }

    /** @test */
    public function shouldReturnBestFitWhenAcceptEncodingsWithMultiArguments()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-encoding' => 'gzip, compress;q=0.2'
        ];

        $this->assertSame('gzip', $ctx->acceptsEncodings('compress', 'gzip'));
        $this->assertSame('gzip', $ctx->acceptsEncodings('gzip', 'compress'));
    }

    /** @test */
    public function shouldReturnBestFitWhenAcceptEncodingsWithArray()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-encoding' => 'gzip, compress;q=0.2'
        ];

        $this->assertSame('gzip', $ctx->acceptsEncodings(['compress', 'gzip']));
    }

    /** @test */
    public function shouldReturnAcceptedTypesWhenAcceptLanguageIsPopulated()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-language' => 'en;q=0.8, es, pt'
        ];

        $this->assertSame(['es', 'pt', 'en'], $ctx->acceptsLanguages());
    }

    /** @test */
    public function shouldReturnBestFitIfAnyTypesMatchWhenAcceptLanguage()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-language' => 'en;q=0.8, es, pt'
        ];

        $this->assertSame('es', $ctx->acceptsLanguages('en', 'es'));
    }

    /** @test */
    public function shouldReturnFalseIfNoTypesMatchWhenAcceptLanguage()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-language' => 'en;q=0.8, es, pt'
        ];

        $this->assertSame(false, $ctx->acceptsLanguages('fr', 'au'));
    }

    /** @test */
    public function shouldReturnFirstTypeWhenAcceptLanguageNotPopulated()
    {
        $ctx = create();
        $this->assertSame('en', $ctx->acceptsLanguages('en', 'es'));
    }

    /** @test */
    public function shouldReturnBestFitWithArrayWhenAcceptLanguagePopulated()
    {
        $ctx = create();
        $ctx->request->headers = [
            'accept-language' => 'en;q=0.8, es, pt'
        ];

        $this->assertSame('es', $ctx->acceptsLanguages(['es', 'en']));
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

    /** @test */
    public function shouldReturnFalseWhenReqMethodIsNotGetAndHead()
    {
        $ctx = create();
        $ctx->request->method = 'POST';
        $this->assertSame(false, $ctx->fresh);
    }

    /** @test */
    public function shouldReturnFalseWhenResponseIsNon2xx()
    {
        $ctx = create();
        $ctx->status = 404;
        $ctx->request->method = 'GET';
        $ctx->request->headers = [
            'if-none-match' => '123'
        ];

        $ctx->set('ETag', '123');
        $this->assertSame(false, $ctx->fresh);
    }

    /** @test */
    public function shouldReturnTrueAndEtagMatchWhenReponseIs2xx()
    {
        $ctx = create();
        $ctx->status = 200;
        $ctx->request->method = 'GET';
        $ctx->request->headers = [
            'if-none-match' => '123'
        ];
        $ctx->set('ETag', '123');
        $this->assertSame(true, $ctx->fresh);
    }

    /** @test */
    public function shouldReturnFalseAndEtagDONTMatchWhenResponseIs2xx()
    {
        $ctx = create();
        $ctx->status = 200;
        $ctx->request->method = 'GET';
        $ctx->request->headers = [
            'if-none-match' => '123'
        ];
        $ctx->set('ETag', 'hey');
        $this->assertSame(false, $ctx->fresh);
    }

    /** @test */
    public function shouldReturnFieldValue()
    {
        $ctx = create();
        $ctx->request->headers = [
            'host' => 'http://google.com',
            'referer' => 'http://google.com'
        ];

        $this->assertSame('http://google.com', $ctx->get('HOST'));
        $this->assertSame('http://google.com', $ctx->get('Host'));
        $this->assertSame('http://google.com', $ctx->get('host'));
        $this->assertSame('http://google.com', $ctx->get('referer'));
        $this->assertSame('http://google.com', $ctx->get('referrer'));
    }

    /** @test */
    public function shouldReturnRequestHeader()
    {
        $req = $this->createRequest();
        $this->assertSame($req->header, $req->req->getHeaders());
    }

    /** @test */
    public function shouldReturnSetRequestHeader()
    {
        $req = $this->createRequest();
        $req->headers = [
            'X-Custom-Headerfield' => 'Its one header, with headerfields'
        ];
        $this->assertSame($req->header, $req->req->getHeaders());
    }


    /** @test */
    public function shouldReturnRequestHeaders()
    {
        $req = $this->createRequest();
        $this->assertSame($req->headers, $req->req->getHeaders());
    }

    /** @test */
    public function shouldReturnSetRequestHeaders()
    {
        $req = $this->createRequest();
        $req->headers = [
            'X-Custom-Headerfield' => 'Its one header, with headerfields'
        ];
        $this->assertSame($req->headers, $req->req->getHeaders());
    }

    /** @test */
    public function shouldReturnHostWithPort()
    {
        $req = $this->createRequest();
        $req->headers = [
            'host' => 'foo.com:3000'
        ];

        $this->assertSame('foo.com:3000', $req->host);
    }

    /** @test */
    public function shouldReturnEmptyStringWithNoHostPresent()
    {
        $req = $this->createRequest();
        $this->assertSame('', $req->host);
    }

    /** @test */
    public function shouldNotUseAuthorityHeaderWhenLessThenHttp2()
    {
        $req = $this->createRequest();
        $req->headers = [
            ':authority' => 'foo.com:3000',
            'host' => 'bar.com:8000'
        ];

        $this->assertSame('bar.com:8000', $req->host);
    }

    /** @test */
    public function shouldUserAuthorityHeaderWhenHttp2()
    {
        $req = $this->createRequest();
        $req->app->updateReq($req->req->withProtocolVersion('2'));
        $req->headers = [
            ':authority' => 'foo.com:3000',
            'host' => 'bar.com:8000'
        ];

        $this->assertSame('foo.com:3000', $req->host);
    }

    /** @test */
    public function shouldUserHostHeaderAsFallback()
    {
        $req = $this->createRequest();
        $req->app->updateReq($req->req->withProtocolVersion('2'));
        $req->headers = [
            'host' => 'bar.com:8000'
        ];

        $this->assertSame('bar.com:8000', $req->host);
    }

    /** @test */
    public function shouldBeIgnoredOnHttp1AndProxyNotTrustedWhenXPresent()
    {
        $req = $this->createRequest();
        $req->headers = [
            'x-forwarded-host' => 'bar.com',
            'host' => 'foo.com'
        ];
        $this->assertSame('foo.com', $req->host);
    }

    /** @test */
    public function shouldBeIgnoredOnHttp2AndProxyNotTrustedWhenXPresent()
    {
        $req = $this->createRequest();
        $req->app->updateReq($req->req->withProtocolVersion('2'));

        $req->headers = [
            'x-forwarded-host' => 'proxy.com:8080',
            ':authority' => 'foo.com:3000',
            'host' => 'bar.com:8000'
        ];

        $this->assertSame('foo.com:3000', $req->host);
    }

    /** @test */
    public function shouldBeUsedOnHttp1AndProxyTrusted()
    {
        $req = $this->createRequest();
        $req->app->proxy = true;
        $req->headers = [
            'x-forwarded-host' => 'bar.com, baz.com',
            'host' => 'foo.com'
        ];

        $this->assertSame('bar.com', $req->host);
    }

    /** @test */
    public function shouldBeUsedOnHttp2AndProxyTrusted()
    {
        $req = $this->createRequest();
        $req->app->updateReq($req->req->withProtocolVersion('2'));
        $req->app->proxy = true;

        $req->headers = [
            'x-forwarded-host' => 'proxy.com:8080',
            ':authority' => 'foo.com:3000',
            'host' => 'bar.com:8000'
        ];

        $this->assertSame('proxy.com:8080', $req->host);
    }

    /** @test */
    public function shouldReturnUllRequestUrl()
    {
        $ctx = createWithReqOpt(
            'get',
            '/users/1?next=/dashboard',
            [
                'host' => 'localhost'
            ]
        );

        $this->assertSame('http://localhost/users/1?next=/dashboard', $ctx->href);
        $ctx->url = '/foo/users/1?next=/dashboard';
        $this->assertSame('http://localhost/users/1?next=/dashboard', $ctx->href);
    }

    /** @test */
    public function shouldReturnTrueWhenRequestMethodIdempotent()
    {
        $arr = ['GET', 'HEAD', 'PUT', 'DELETE', 'OPTIONS', 'TRACE'];
        array_map(function ($method) {
            $req = $this->createRequest();
            $req->method = $method;
            $this->assertTrue($req->idempotent);
        }, $arr);
    }

    /** @test */
    public function shouldReturnFalseWhenRequestMethodNotIdempotent()
    {
        $req = $this->createRequest();
        $req->method = 'POST';
        $this->assertFalse($req->idempotent);
    }

    /** @test */
    public function shouldReturnReqIpsWhenPresent()
    {
        $app = new Application(['proxy' => true]);
        $req = new ServerRequest('GET', '/', [
            'x-forwarded-for' => '127.0.0.1'
        ]);
        $res = new \React\Http\Message\Response();
        $ctx = createAll($req, $res, $app);
        $this->assertSame('127.0.0.1', $ctx->request->ip);
    }

    /** @test */
    public function shouldPassedWhenXForwardedForPresent()
    {
        {

            $req = $this->createRequest();
            $req->app->proxy = false;
            $req->headers = [
                'x-forwarded-for' => '127.0.0.1,127.0.0.2'
            ];

            $this->assertSame([], $req->ips);
        }

        {
            $req = $this->createRequest();
            $req->app->proxy = true;
            $req->headers = [
                'x-forwarded-for' => '127.0.0.1,127.0.0.2'
            ];

            $this->assertSame(['127.0.0.1', '127.0.0.2'], $req->ips);
        }

    }

    /** @test */
    public function shouldPassWhenProxyIpHeaderPresent()
    {
        {
            $req = $this->createRequest();
            $req->app->proxy = false;
            $req->app->proxyIpHeader = 'x-client-ip';
            $req->headers = [
                'x-client-ip' => '127.0.0.1,127.0.0.2'
            ];

            $this->assertSame([], $req->ips);
        }

        {
            $req = $this->createRequest();
            $req->app->proxy = true;
            $req->app->proxyIpHeader = 'x-client-ip';
            $req->headers = [
                'x-client-ip' => '127.0.0.1,127.0.0.2'
            ];

            $this->assertSame(['127.0.0.1', '127.0.0.2'], $req->ips);
        }
    }

    /** @test */
    public function shouldPassWhenMaxIpsCountPresent()
    {
        {
            $req = $this->createRequest();
            $req->app->proxy = false;
            $req->app->maxIpCount = 1;
            $req->headers = [
                'x-forwarded-for' => '127.0.0.1,127.0.0.2'
            ];

            $this->assertSame([], $req->ips);
        }

        {
            $req = $this->createRequest();
            $req->app->proxy = true;
            $req->app->maxIpCount = 1;
            $req->headers = [
                'x-forwarded-for' => '127.0.0.1,127.0.0.2'
            ];

            $this->assertSame(['127.0.0.2'], $req->ips);
        }
    }
}
