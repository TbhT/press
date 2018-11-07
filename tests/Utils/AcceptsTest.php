<?php
declare(strict_types=1);

use Press\Utils\Accepts;
use Swoole\Http\Request;
use PHPUnit\Framework\TestCase;


class AcceptsTest extends TestCase
{
    private static function createRequestCharset($charset = null)
    {
        $req = new Request();
        $req->header = [
            'accept-charset' => $charset
        ];

        return $req;
    }

    private static function createRequestEncoding($encoding = null)
    {
        $req = new Request();
        $req->header = [
            'accept-encoding' => $encoding
        ];

        return $req;
    }

    private static function createRequestLanguage($language = null)
    {
        $req = new Request();
        $req->header = [
            'accept-language' => $language
        ];

        return $req;
    }

    private static function createRequestType($type = null)
    {
        $req = new Request();
        $req->header = [
            'accept' => $type
        ];

        return $req;
    }


    /**
     * accept-headers, expected
     * @return array
     */
    public function charsetWithNoArgumentsData()
    {
        return [
            [
                'utf-8, iso-8859-1;q=0.2, utf-7;q=0.5',
                ['utf-8', 'utf-7', 'iso-8859-1']
            ],
            [
                null, ['*']
            ],
            [
                '', []
            ]
        ];
    }


    /**
     * @dataProvider charsetWithNoArgumentsData
     * @param $accept_header
     * @param $expected
     */
    public function testCharsetWithNoArguments($accept_header, $expected)
    {
        $req = self::createRequestCharset($accept_header);
        $accept = new Accepts($req);
        $charsets = $accept->charsets();
        self::assertEquals($expected, $charsets);
    }


    public function testCharsetWithMultipleArguments()
    {
        $req1 = self::createRequestCharset('utf-8, iso-8859-1;q=0.2, utf-7;q=0.5');
        $accept1 = new Accepts($req1);
        $charsets1 = $accept1->charsets('utf-7', 'utf-8');
        self::assertEquals('utf-8', $charsets1);


        $req2 = self::createRequestCharset('utf-8, iso-8859-1;q=0.2, utf-7;q=0.5');
        $accept2 = new Accepts($req2);
        $charsets2 = $accept2->charsets('utf-16');
        self::assertEquals(false, $charsets2);

        $req3 = self::createRequestCharset();
        $accept3 = new Accepts($req3);
        $charsets3 = $accept3->charsets('utf-7', 'utf-8');
        self::assertEquals('utf-7', $charsets3);
    }


    public function testCharsetWithArray()
    {
        $req = self::createRequestCharset('utf-8, iso-8859-1;q=0.2, utf-7;q=0.5');
        $accept = new Accepts($req);
        $charsets = $accept->charsets(['utf-7', 'utf-8']);
        self::assertEquals('utf-8', $charsets);
    }


    public function testEncodingWithNoArguments()
    {
        $req = self::createRequestEncoding('gzip, compress;q=0.2');
        $accept = new Accepts($req);

        self::assertEquals(['gzip', 'compress', 'identity'], $accept->encodings());
        self::assertEquals('gzip', $accept->encodings('gzip', 'compress'));
    }


    public function testEncodingWhenNotInRequest()
    {
        $req = self::createRequestEncoding();
        $accept = new Accepts($req);

        self::assertEquals(['identity'], $accept->encodings());
        self::assertEquals('identity', $accept->encodings('gzip', 'deflate', 'identity'));
    }


    public function testEncodingWhenIdentityNotInclude()
    {
        $req = self::createRequestEncoding();
        $accept = new Accepts($req);

        self::assertEquals(false, $accept->encodings('gzip', 'deflate'));
    }


    public function testEncodingWhenEmpty()
    {
        $req = self::createRequestEncoding('');
        $accept = new Accepts($req);

        self::assertEquals(['identity'], $accept->encodings());
        self::assertEquals('identity', $accept->encodings('gzip', 'deflate', 'identity'));
    }


    public function testEncodingWhenEmptyAndIdentityNotInclude()
    {
        $req = self::createRequestEncoding('');
        $accept = new Accepts($req);

        self::assertEquals(false, $accept->encodings('gzip', 'deflate'));
    }


    public function testEncodingWithMultiArguments()
    {
        $req = self::createRequestEncoding('gzip, compress;q=0.2');
        $accept = new Accepts($req);

        self::assertEquals('gzip', $accept->encodings('compress', 'gzip'));
        self::assertEquals('gzip', $accept->encodings('gzip', 'compress'));
    }


    public function testEncodingWithMultiArgumentsInArray()
    {
        $req = self::createRequestEncoding('gzip, compress;q=0.2');
        $accept = new Accepts($req);

        self::assertEquals('gzip', $accept->encodings(['compress', 'gzip']));
    }


    public function testLanguageWithNoArguments()
    {
        $req1 = self::createRequestLanguage('en;q=0.8, es, pt');
        $accept1 = new Accepts($req1);
        self::assertEquals(['es', 'pt', 'en'], $accept1->languages());

        $req2 = self::createRequestLanguage();
        $accept2 = new Accepts($req2);
        self::assertEquals(['*'], $accept2->languages());

        $req3 = self::createRequestLanguage('');
        $accept3 = new Accepts($req3);
        self::assertEquals([], $accept3->languages());
    }


    public function testLanguageWithMultiArguments()
    {
        $req = self::createRequestLanguage('en;q=0.8, es, pt');
        $accept = new Accepts($req);
        self::assertEquals('es', $accept->languages('es', 'en'));

        $req1 = self::createRequestLanguage('en;q=0.8, es, pt');
        $accept1 = new Accepts($req1);
        self::assertEquals(false, $accept1->languages('fr', 'au'));

        $req2 = self::createRequestLanguage();
        $accept2 = new Accepts($req2);
        self::assertEquals('es', $accept2->languages('es', 'en'));
    }


    public function testLanguageWithArray()
    {
        $req = self::createRequestLanguage('en;q=0.8, es, pt');
        $accept = new Accepts($req);
        self::assertEquals('es', $accept->languages(['es', 'en']));
    }


    public function testTypesWithNoArguments()
    {
        $req = self::createRequestType('application/*;q=0.2, image/jpeg;q=0.8, text/html, text/plain');
        $accept = new Accepts($req);
        self::assertEquals(['text/html', 'text/plain', 'image/jpeg', 'application/*'], $accept->types());

        $req1 = self::createRequestType();
        $accept1 = new Accepts($req1);
        self::assertEquals(['*/*'], $accept1->types());

        $req2 = self::createRequestType('');
        $accept2 = new Accepts($req2);
        self::assertEquals([], $accept2->types());
    }


    public function testTypesNoValid()
    {
        $req = self::createRequestType('application/*;q=0.2, image/jpeg;q=0.8, text/html, text/plain');
        $accept = new Accepts($req);
        self::assertEquals(false, $accept->types('image/png', 'image/tiff'));

        $req1 = self::createRequestType();
        $accept1 = new Accepts($req1);
        self::assertEquals('text/html', $accept1->types('text/html', 'text/plain', 'image/jpeg', 'application/*'));
    }


    public function testTypesWhenExtensionsGiven()
    {
        $req = self::createRequestType('text/plain, text/html');
        $accept = new Accepts($req);

        self::assertEquals('html', $accept->types('html'));
        self::assertEquals('.html', $accept->types('.html'));
        self::assertEquals('txt', $accept->types('txt'));
        self::assertEquals('.txt', $accept->types('.txt'));
        self::assertEquals(false, $accept->types('png'));
        self::assertEquals(false, $accept->types('bogus'));
    }


    public function testTypesWithArray()
    {
        $req = self::createRequestType('text/plain, text/html');
        $accept = new Accepts($req);

        self::assertEquals('text', $accept->types(['png', 'text', 'html']));
        self::assertEquals('html', $accept->types(['png', 'html']));
        self::assertEquals('html', $accept->types(['bogus', 'html']));
    }


    public function testTypesWithMultiArguments()
    {
        $req = self::createRequestType('text/plain, text/html');
        $accept = new Accepts($req);

        self::assertEquals('text', $accept->types('png', 'text', 'html'));
        self::assertEquals('html', $accept->types('png', 'html'));
        self::assertEquals('html', $accept->types('bogus', 'html'));
    }


    public function testTypesWithExactMatch()
    {
        $req = self::createRequestType('text/plain, text/html');
        $accept = new Accepts($req);

        self::assertEquals('text/html', $accept->types('text/html'));
        self::assertEquals('text/plain', $accept->types('text/plain'));
    }


    public function testTypesWithTypeMatch()
    {
        $req = self::createRequestType('application/json, */*');
        $accept = new Accepts($req);

        self::assertEquals('text/html', $accept->types('text/html'));
        self::assertEquals('text/plain', $accept->types('text/plain'));
        self::assertEquals('image/png', $accept->types('image/png'));
    }


    public function testTypesWithSubtypeMatch()
    {
        $req = self::createRequestType('application/json, text/*');
        $accept = new Accepts($req);

        self::assertEquals('text/html', $accept->types('text/html'));
        self::assertEquals('text/plain', $accept->types('text/plain'));
        self::assertEquals(false, $accept->types('image/png'));
    }
}
