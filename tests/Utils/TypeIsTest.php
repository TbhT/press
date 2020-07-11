<?php
declare(strict_types=1);

namespace Press\Tests\Utils;

use PHPUnit\Framework\TestCase;
use stdClass;
use function Press\Utils\hasBody;
use function Press\Utils\typeOfRequest;


class TypeIsTest extends TestCase
{
    private function createRequest($type = '')
    {
        $req = new stdClass();
        $type = !$type ? '' : $type;
        $req->header = [];
        $req->header['content-type'] = $type;
        $req->header['transfer-encoding'] = 'chunked';
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
        $req = new stdClass();
        $req->header = [];

        self::assertEquals(null, typeOfRequest($req));
        self::assertEquals(null, typeOfRequest($req, ['image/*']));
        self::assertEquals(null, typeOfRequest($req, 'image/*', 'text/*'));
    }

    public function testNoContentType()
    {
        $req = new stdClass();
        $req->header = [];

        self::assertEquals(false, typeOfRequest($req));
        self::assertEquals(false, typeOfRequest($req, ['image/*']));
        self::assertEquals(false, typeOfRequest($req, ['text/*', 'image/*']));
    }

    public function testNoTypes()
    {
        $req = self::createRequest('image/png');

        self::assertEquals('image/png', typeOfRequest($req));
    }

    public function testOneType()
    {
        $req = self::createRequest('image/png');

        self::assertEquals('png', typeOfRequest($req, ['png']));
        self::assertEquals('.png', typeOfRequest($req, ['.png']));
        self::assertEquals('image/png', typeOfRequest($req, ['image/png']));
        self::assertEquals('image/png', typeOfRequest($req, ['image/*']));
        self::assertEquals('image/png', typeOfRequest($req, ['*/png']));

        self::assertEquals(false, typeOfRequest($req, ['jpeg']));
        self::assertEquals(false, typeOfRequest($req, ['.jpeg']));
        self::assertEquals(false, typeOfRequest($req, ['image/jpeg']));
        self::assertEquals(false, typeOfRequest($req, ['text/*']));
        self::assertEquals(false, typeOfRequest($req, ['*/jpeg']));

        self::assertEquals(false, typeOfRequest($req, ['bogus']));
        self::assertEquals(false, typeOfRequest($req, ['something/bogus']));
    }

    public function testMultiTypes()
    {
        $req = self::createRequest('image/png');

        self::assertEquals('png', typeOfRequest($req, ['png']));
        self::assertEquals('.png', typeOfRequest($req, '.png'));
        self::assertEquals('image/png', typeOfRequest($req, ['text/*', 'image/*']));
        self::assertEquals('image/png', typeOfRequest($req, ['image/*', 'text/*']));
        self::assertEquals('image/png', typeOfRequest($req, ['image/*', 'image/png']));
        self::assertEquals('image/png', typeOfRequest($req, 'image/png', 'image/*'));

        self::assertEquals(false, typeOfRequest($req, ['jpeg']));
        self::assertEquals(false, typeOfRequest($req, ['.jpeg']));
        self::assertEquals(false, typeOfRequest($req, ['text/*', 'application/*']));
        self::assertEquals(false, typeOfRequest($req, ['text/html', 'text/plain', 'application/json']));
    }

    public function testGivenSuffix()
    {
        $req = self::createRequest('application/vnd+json');

        self::assertEquals('application/vnd+json', typeOfRequest($req, '+json'));
        self::assertEquals('application/vnd+json', typeOfRequest($req, 'application/vnd+json'));
        self::assertEquals('application/vnd+json', typeOfRequest($req, 'application/*+json'));
        self::assertEquals('application/vnd+json', typeOfRequest($req, '*/vnd+json'));
        self::assertEquals(false, typeOfRequest($req, 'application/json'));
        self::assertEquals(false, typeOfRequest($req, 'text/*+json'));
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

        $result = typeOfRequest($req, $accept);
        self::assertEquals($expected, $result);
    }

    public function testNoMatchBodyLess()
    {
        $req = new stdClass();
        $req->header = ['content-type' => 'text/html'];

        $result = typeOfRequest($req, '*/*');
        self::assertEquals(false, $result);
    }

    public function testFormUrlencoded()
    {
        $req = self::createRequest('application/x-www-form-urlencoded');

        self::assertEquals('urlencoded', typeOfRequest($req, ['urlencoded']));
        self::assertEquals('urlencoded', typeOfRequest($req, ['json', 'urlencoded']));
        self::assertEquals('urlencoded', typeOfRequest($req, ['urlencoded', 'json']));
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
        $result = typeOfRequest($req, $type);

        self::assertEquals($expected, $result);
    }

    public function testMultipartData()
    {
        $req = self::createRequest('multipart/form-data');
        self::assertEquals('multipart/form-data', typeOfRequest($req, ['multipart/*']));
        self::assertEquals('multipart', typeOfRequest($req, ['multipart']));
    }

    public function testHasBodyContentLength()
    {
        $req = new stdClass();

        $req->header = ['content-length' => '1'];
        self::assertEquals(true, hasBody($req));

        $req->header = ['content-length' => '0'];
        self::assertEquals(true, hasBody($req));

        // todo 这块地方的逻辑不太对
        $req->header = ['content-length' => 'bogus'];
        self::assertEquals(false, hasBody($req));
    }

    public function testHasBodyTransferEncoding()
    {
        $req = new stdClass();
        $req->header = ['transfer-encoding' => 'chunked'];

        self::assertEquals(true, hasBody($req));
    }
}