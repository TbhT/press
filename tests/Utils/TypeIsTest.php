<?php
declare(strict_types=1);

use Press\Request;
use Press\Utils\TypeIs;
use PHPUnit\Framework\TestCase;


class TypeIsTest extends TestCase
{
    private function createRequest($type = '')
    {
        $req = new Request();
        $type = !$type ? '' : $type;
        $req->headers['content-type'] = $type;
        $req->headers['transfer-encoding'] = 'chunked';
        return $req;
    }

    /**
     * request, $type, expected
     * @return array
     */
    public function typeIsData()
    {
        return [
            [
                'text/html; charset=utf-8', ['text/*'], 'text/html'
            ],
            [
                'text/html ; charset=utf-8', ['text/*'], 'text/html'
            ],
            [
                'text/HTML', ['text/*'], 'text/html'
            ],
            [
                'text/html**', ['text/*'], false
            ],
            [
                'text/html', ['text/html/'], false
            ],
            [
                'text/html', [null, true, function () {
            }], false
            ]
        ];
    }

    public function testNoBodyTypeIs()
    {
        $req = new Request();
        $req->headers = [];

        self::assertEquals(null, TypeIs::typeOfRequest($req));
        self::assertEquals(null, TypeIs::typeOfRequest($req, ['image/*']));
        self::assertEquals(null, TypeIs::typeOfRequest($req, 'image/*', 'text/*'));
    }

    public function testNoContentType()
    {
        $req = self::createRequest();

        self::assertEquals(false, TypeIs::typeOfRequest($req));
        self::assertEquals(false, TypeIs::typeOfRequest($req, ['image/*']));
        self::assertEquals(false, TypeIs::typeOfRequest($req, ['text/*', 'image/*']));
    }

    public function testNoTypes()
    {
        $req = self::createRequest('image/png');

        self::assertEquals('image/png', TypeIs::typeOfRequest($req));
    }

    public function testOneType()
    {
        $req = self::createRequest('image/png');

        self::assertEquals('png', TypeIs::typeOfRequest($req, ['png']));
        self::assertEquals('.png', TypeIs::typeOfRequest($req, ['.png']));
        self::assertEquals('image/png', TypeIs::typeOfRequest($req, ['image/png']));
        self::assertEquals('image/png', TypeIs::typeOfRequest($req, ['image/*']));
        self::assertEquals('image/png', TypeIs::typeOfRequest($req, ['*/png']));

        self::assertEquals(false, TypeIs::typeOfRequest($req, ['jpeg']));
        self::assertEquals(false, TypeIs::typeOfRequest($req, ['.jpeg']));
        self::assertEquals(false, TypeIs::typeOfRequest($req, ['image/jpeg']));
        self::assertEquals(false, TypeIs::typeOfRequest($req, ['text/*']));
        self::assertEquals(false, TypeIs::typeOfRequest($req, ['*/jpeg']));

        self::assertEquals(false, TypeIs::typeOfRequest($req, ['bogus']));
        self::assertEquals(false, TypeIs::typeOfRequest($req, ['something/bogus']));
    }

    public function testMultiTypes()
    {
        $req = self::createRequest('image/png');

        self::assertEquals('png', TypeIs::typeOfRequest($req, ['png']));
        self::assertEquals('.png', TypeIs::typeOfRequest($req, '.png'));
        self::assertEquals('image/png', TypeIs::typeOfRequest($req, ['text/*', 'image/*']));
        self::assertEquals('image/png', TypeIs::typeOfRequest($req, ['image/*', 'text/*']));
        self::assertEquals('image/png', TypeIs::typeOfRequest($req, ['image/*', 'image/png']));
        self::assertEquals('image/png', TypeIs::typeOfRequest($req, 'image/png', 'image/*'));

        self::assertEquals(false, TypeIs::typeOfRequest($req, ['jpeg']));
        self::assertEquals(false, TypeIs::typeOfRequest($req, ['.jpeg']));
        self::assertEquals(false, TypeIs::typeOfRequest($req, ['text/*', 'application/*']));
        self::assertEquals(false, TypeIs::typeOfRequest($req, ['text/html', 'text/plain', 'application/json']));
    }

    public function testGivenSuffix()
    {
        $req = self::createRequest('application/vnd+json');

        self::assertEquals('application/vnd+json', TypeIs::typeOfRequest($req, '+json'));
        self::assertEquals('application/vnd+json', TypeIs::typeOfRequest($req, 'application/vnd+json'));
        self::assertEquals('application/vnd+json', TypeIs::typeOfRequest($req, 'application/*+json'));
        self::assertEquals('application/vnd+json', TypeIs::typeOfRequest($req, '*/vnd+json'));
        self::assertEquals(false, TypeIs::typeOfRequest($req, 'application/json'));
        self::assertEquals(false, TypeIs::typeOfRequest($req, 'text/*+json'));
    }

    /**
     * header, accept-type, expected
     * @return array
     */
    public function allTypesData()
    {
        return [
            [
                'text/html', '*/*', 'text/html'
            ],
            [
                'text/xml', '*/*', 'text/xml'
            ],
            [
                'application/json', '*/*', 'application/json'
            ],
            [
                'application/vnd+json', '*/*', 'application/vnd+json'
            ],
            [
                'bogus', '*/*', false
            ]
        ];
    }

    /**
     * @dataProvider allTypesData
     * @param $header
     * @param $accept
     * @param $expected
     */
    public function testAllTypes($header, $accept, $expected)
    {
        $req = self::createRequest($header);

        $result = TypeIs::typeOfRequest($req, $accept);
        self::assertEquals($expected, $result);
    }

    public function testNoMatchBodyLess()
    {
        $req = new Request();
        $req->headers = ['content-type' => 'text/html'];

        $result = TypeIs::typeOfRequest($req, '*/*');
        self::assertEquals(false, $result);
    }

    public function testFormUrlencoded()
    {
        $req = self::createRequest('application/x-www-form-urlencoded');

        self::assertEquals('urlencoded', TypeIs::typeOfRequest($req, ['urlencoded']));
        self::assertEquals('urlencoded', TypeIs::typeOfRequest($req, ['json', 'urlencoded']));
        self::assertEquals('urlencoded', TypeIs::typeOfRequest($req, ['urlencoded', 'json']));
    }

    /**
     * @dataProvider typeIsData
     * @param $header
     * @param $type
     * @param $expected
     */
    public function testTypeIs($header, $type, $expected)
    {
        $req = $this->createRequest($header);
        $result = TypeIs::typeOfRequest($req, $type);

        self::assertEquals($expected, $result);
    }

    public function testMultipartData()
    {
        $req = self::createRequest('multipart/form-data');
        self::assertEquals('multipart/form-data', TypeIs::typeOfRequest($req, ['multipart/*']));
        self::assertEquals('multipart', TypeIs::typeOfRequest($req, ['multipart']));
    }

    public function testHasBodyContentLength()
    {
        $req = new Request();

        $req->headers = ['content-length' => '1'];
        self::assertEquals(true, TypeIs::hasBody($req));

        $req->headers = ['content-length' => '0'];
        self::assertEquals(true, TypeIs::hasBody($req));

        // todo 这块地方的逻辑不太对
        $req->headers = ['content-length' => 'bogus'];
        self::assertEquals(false, TypeIs::hasBody($req));
    }

    public function testHasBodyTransferEncoding()
    {
        $req = new Request();
        $req->headers = ['transfer-encoding' => 'chunked'];

        self::assertEquals(true, TypeIs::hasBody($req));
    }
}
