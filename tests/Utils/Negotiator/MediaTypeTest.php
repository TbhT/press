<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Press\Request;
use Press\Utils\Negotiator;


class MediaTypeTest extends TestCase
{
    /**
     * accept-mediaType, expected
     * @return array
     */
    public function mediaTypeData()
    {
        return [
            [
                null, '*/*'
            ],
            [
                '*/*', '*/*'
            ],
            [
                'application/json', 'application/json'
            ],
            [
                'application/json;q=0', null
            ],
            [
                'application/json;q=0.2, text/html', 'text/html'
            ],
            [
                'text/*', 'text/*'
            ],
            [
                'text/plain, application/json;q=0.5, text/html, */*;q=0.1', 'text/plain'
            ],
            [
                'text/plain, application/json;q=0.5, text/html, text/xml, text/yaml, text/javascript, text/csv, text/css, text/rtf, text/markdown, application/octet-stream;q=0.2, */*;q=0.1', 'text/plain'
            ]
        ];
    }

    /**
     * accept-mediaType, mediaType, expected
     * @return array
     */
    public function mediaTypeArrayData()
    {
        return [
            [
                null, ['text/html'], 'text/html'
            ],
            [
                null, ['text/html', 'application/json'], 'text/html'
            ],
            [
                null, ['application/json', 'text/html'], 'application/json'
            ],
            [
                '*/*', ['text/html'], 'text/html'
            ],
            [
                '*/*', ['text/html', 'application/json'], 'text/html'
            ],
            [
                '*/*', ['application/json', 'text/html'], 'application/json'
            ],
            [
                'application/json', ['application/JSON'], 'application/JSON'
            ],
            [
                'application/json;q=0', null, null
            ],
            [
                'application/json;q=0.2, text/html', ['application/json'], 'application/json'
            ],
            [
                'application/json;q=0.2, text/html', ['application/json', 'text/html'], 'text/html'
            ],
            [
                'application/json;q=0.2, text/html', ['text/html', 'application/json'], 'text/html'
            ],
            [
                'text/*', ['application/json'], null
            ],
            [
                'text/*', ['application/json', 'text/html'], 'text/html'
            ],
            [
                'text/*', ['text/html', 'application/json'], 'text/html'
            ],
            [
                'text/plain, application/json;q=0.5, text/html, */*;q=0.1',
                ['application/json', 'text/plain', 'text/html'],
                'text/plain'
            ],
            [
                'text/plain, application/json;q=0.5, text/html, */*;q=0.1',
                ['image/jpeg', 'text/html'],
                'text/html'
            ],
            [
                'text/plain, application/json;q=0.5, text/html, */*;q=0.1', ['image/jpeg', 'image/gif'], 'image/jpeg'
            ],
            [
                'text/plain, application/json;q=0.5, text/html, text/xml, text/yaml, text/javascript, text/csv, text/css, text/rtf, text/markdown, application/octet-stream;q=0.2, */*;q=0.1',
                ['text/plain', 'text/html', 'text/xml', 'text/yaml', 'text/javascript', 'text/csv', 'text/css', 'text/rtf', 'text/markdown', 'application/json', 'application/octet-stream'],
                'text/plain'
            ]
        ];
    }

    /**
     * accept-mediaTye, expected
     * @return array
     */
    public function mediaTypesData()
    {
        return [
            [
                null, ['*/*']
            ],
            [
                '*/*', ['*/*']
            ],
            [
                'application/json', ['application/json']
            ],
            [
                'application/json;q=0', []
            ],
            [
                'application/json;q=0.2, text/html', ['text/html', 'application/json']
            ],
            [
                'text/*', ['text/*']
            ],
            [
                'text/*, text/plain;q=0', ['text/*']
            ],
            [
                'text/html;LEVEL=1', ['text/html']
            ],
            [
                'text/html;foo="bar,text/css;";fizz="buzz,5", text/plain', ['text/html', 'text/plain']
            ],
            [
                'text/plain, application/json;q=0.5, text/html, */*;q=0.1', ['text/plain', 'text/html', 'application/json', '*/*']
            ],
            [
                'text/plain, application/json;q=0.5, text/html, text/xml, text/yaml, text/javascript, text/csv, text/css, text/rtf, text/markdown, application/octet-stream;q=0.2, */*;q=0.1',
                ['text/plain', 'text/html', 'text/xml', 'text/yaml', 'text/javascript', 'text/csv', 'text/css', 'text/rtf', 'text/markdown', 'application/json', 'application/octet-stream', '*/*']
            ]
        ];
    }

    /**
     * accept media types,
     * @return array
     */
    public function mediaTypesArrayData()
    {
        return [
            [
                null, ['application/json', 'text/plain'], ['application/json', 'text/plain']
            ],
            [
                '*/*', ['application/json', 'text/plain'], ['application/json', 'text/plain']
            ],
            [
                '*/*;q=0.8, text/*, image/*',
                ['application/json', 'text/html', 'text/plain', 'text/xml', 'application/xml', 'image/gif', 'image/jpeg', 'image/png', 'audio/mp3', 'application/javascript', 'text/javascript'],
                ['text/html', 'text/plain', 'text/xml', 'text/javascript', 'image/gif', 'image/jpeg', 'image/png', 'application/json', 'application/xml', 'audio/mp3', 'application/javascript']
            ],
            [
                'application/json',
                ['application/json'],
                ['application/json']
            ],
            [
                'application/json',
                ['application/JSON'],
                ['application/JSON']
            ],
            [
                'application/json',
                ['application/JSON'],
                ['application/JSON']
            ],
            [
                'application/json',
                ['text/html', 'application/json'],
                ['application/json']
            ],
            [
                'application/json',
                ['boom', 'application/json'],
                ['application/json']
            ],
            [
                'application/json;q=0',
                ['application/json'],
                []
            ],
            [
                'application/json;q=0',
                ['application/json', 'text/html', 'image/jpeg'],
                []
            ],
            [
                'application/json;q=0.2, text/html',
                ['application/json', 'text/html'],
                ['text/html', 'application/json']
            ],
            [
                'application/json;q=0.9, text/html;q=0.8, application/json;q=0.7',
                ['text/html', 'application/json'],
                ['application/json', 'text/html']
            ],
            [
                'application/json, */*;q=0.1',
                ['text/html', 'application/json'],
                ['application/json', 'text/html']
            ],
            [
                'application/xhtml+xml;profile="http://www.wapforum.org/xhtml"',
                ['application/xhtml+xml;profile="http://www.wapforum.org/xhtml"'],
                ['application/xhtml+xml;profile="http://www.wapforum.org/xhtml"']
            ],
            [
                'text/*',
                ['text/html', 'application/json', 'text/plain'],
                ['text/html', 'text/plain']
            ],
            [
                'text/*, text/html;level',
                ['text/html'],
                ['text/html']
            ],
            [
                'text/*, text/plain;q=0',
                ['text/html', 'text/plain'],
                ['text/html']
            ],
            [
                'text/*, text/plain;q=0.5',
                ['text/html', 'text/plain', 'text/xml'],
                ['text/html', 'text/xml', 'text/plain']
            ],
            [
                'text/html;level=1',
                ['text/html;level=1'],
                ['text/html;level=1']
            ],
            [
                'text/html;level=1',
                ['text/html;Level=1'],
                ['text/html;Level=1']
            ],
            [
                'text/html;level=1',
                ['text/html;level=2'],
                []
            ],
            [
                'text/html;level=1',
                ['text/html'],
                []
            ],
            [
                'text/html;level=1',
                ['text/html;level=1;foo=bar'],
                ['text/html;level=1;foo=bar']
            ],
            [
                'text/html;level=1;foo=bar',
                ['text/html;level=1'],
                []
            ],
            [
                'text/html;level=1;foo=bar',
                ['text/html;level=1;foo=bar'],
                ['text/html;level=1;foo=bar']
            ],
            [
                'text/html;level=1;foo=bar',
                ['text/html;foo=bar;level=1'],
                ['text/html;foo=bar;level=1']
            ],
            [
                'text/html;level=1;foo="bar"',
                ['text/html;level=1;foo=bar'],
                ['text/html;level=1;foo=bar']
            ],
            [
                'text/html;level=1;foo="bar"',
                ['text/html;level=1;foo="bar"'],
                ['text/html;level=1;foo="bar"']
            ],
            [
                'text/html;foo=";level=2;"',
                ['text/html;level=2'],
                []
            ],
            [
                'text/html;foo=";level=2;"',
                ['text/html;foo=";level=2;"'],
                ['text/html;foo=";level=2;"']
            ],
            [
                'text/html;LEVEL=1',
                ['text/html;level=1'],
                ['text/html;level=1']
            ],
            [
                'text/html;LEVEL=1',
                ['text/html;Level=1'],
                ['text/html;Level=1']
            ],
            [
                'text/html;LEVEL=1;level=2',
                ['text/html;level=2'],
                ['text/html;level=2']
            ],
            [
                'text/html;LEVEL=1;level=2',
                ['text/html;level=1'],
                []
            ],
            [
                'text/html;level=2',
                ['text/html;level=1'],
                []
            ],
            [
                'text/html;level=2, text/html',
                ['text/html', 'text/html;level=2'],
                ['text/html;level=2', 'text/html']
            ],
            [
                'text/html;level=2;q=0.1, text/html',
                ['text/html;level=2', 'text/html'],
                ['text/html', 'text/html;level=2']
            ],
            [
                'text/html;level=2;q=0.1;level=1',
                ['text/html;level=1'],
                []
            ],
            [
                'text/html;level=2;q=0.1, text/html;level=1, text/html;q=0.5',
                ['text/html;level=1', 'text/html;level=2', 'text/html'],
                ['text/html;level=1', 'text/html', 'text/html;level=2']
            ],
            [
                'text/plain, application/json;q=0.5, text/html, */*;q=0.1',
                ['text/html', 'text/plain'],
                ['text/plain', 'text/html']
            ],
            [
                'text/plain, application/json;q=0.5, text/html, */*;q=0.1',
                ['application/json', 'text/html', 'text/plain'],
                ['text/plain', 'text/html', 'application/json']
            ],
            [
                'text/plain, application/json;q=0.5, text/html, */*;q=0.1',
                ['image/jpeg', 'text/html', 'text/plain'],
                ['text/plain', 'text/html', 'image/jpeg']
            ],
            [
                'text/plain, application/json;q=0.5, text/html, text/xml, text/yaml, text/javascript, text/csv, text/css, text/rtf, text/markdown, application/octet-stream;q=0.2, */*;q=0.1',
                ['text/plain', 'text/html', 'text/xml', 'text/yaml', 'text/javascript', 'text/csv', 'text/css', 'text/rtf', 'text/markdown', 'application/json', 'application/octet-stream'],
                ['text/plain', 'text/html', 'text/xml', 'text/yaml', 'text/javascript', 'text/csv', 'text/css', 'text/rtf', 'text/markdown', 'application/json', 'application/octet-stream']
            ]
        ];
    }

    private function createRequest($headers)
    {
        $request = new Request();
        $request->headers = [];

        if ($headers) {
            foreach ($headers as $key => $header) {
                $request->headers[strtolower($key)] = $header;
            }
        }

        return $request;
    }

    /**
     * @dataProvider mediaTypeData
     * @param $accept_media_type
     * @param $expected
     */
    public function testMediaType($accept_media_type, $expected)
    {
        $request = self::createRequest(['Accept' => $accept_media_type]);
        $negotiator = new Negotiator\Negotiator($request);

        $result = $negotiator->mediaType();
        static::assertEquals($expected, $result);
    }

    /**
     * @dataProvider mediaTypeArrayData
     * @param $accept_media_type
     * @param $media_type
     * @param $expected
     * @return void
     */
    public function testMediaTypeArray($accept_media_type, $media_type, $expected)
    {
        $request = self::createRequest(['Accept' => $accept_media_type]);
        $negotiator = new Negotiator\Negotiator($request);

        $result = $negotiator->mediaType($media_type);
        static::assertEquals($expected, $result);
    }

    /**
     * @dataProvider mediaTypesData
     * @param $accept_media_type
     * @param $expected
     */
    public function testMediaTypes($accept_media_type, $expected)
    {
        $request = self::createRequest(['Accept' => $accept_media_type]);
        $negotiator = new Negotiator\Negotiator($request);

        $result = $negotiator->mediaTypes();
        static::assertEquals($expected, $result);
    }

    /**
     * @dataProvider mediaTypesArrayData
     * @param $accept_media_type
     * @param $media_type
     * @param $expected
     */
    public function testMediaTypesArray($accept_media_type, $media_type, $expected)
    {
        $request = self::createRequest(['Accept' => $accept_media_type]);
        $negotiator = new Negotiator\Negotiator($request);

        $result = $negotiator->mediaTypes($media_type);
        static::assertEquals($expected, $result);
    }
}
