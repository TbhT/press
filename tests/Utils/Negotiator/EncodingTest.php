<?php
declare(strict_types=1);

use Press\Request;
use Press\Utils\Negotiator;
use PHPUnit\Framework\TestCase;


class EncodingTest extends TestCase
{

    /**
     * accept-encoding, expected
     * @return array
     */
    public function encodingData()
    {
        return [
            [
                null, 'identity'
            ],
            [
                '*', '*'
            ],
            [
                '*, gzip', '*'
            ],
            [
                '*, gzip;q=0', '*'
            ],
            [
                '*;q=0', null
            ],
            [
                '*;q=0, identity;q=1', 'identity'
            ],
            [
                'identity', 'identity'
            ],
            [
                'identity;q=0', null
            ],
            [
                'gzip', 'gzip'
            ],
            [
                'gzip, compress;q=0', 'gzip'
            ],
            [
                'gzip, deflate', 'gzip'
            ],
            [
                'gzip;q=0.8, deflate', 'deflate'
            ],
            [
                'gzip;q=0.8, identity;q=0.5, *;q=0.3', 'gzip'
            ]
        ];
    }

    /**
     * accept-encoding, expected, charset
     * @return array
     */
    public function encodingArrayData()
    {
        return [
            [
                null, null, []
            ],
            [
                null, 'identity', ['identity']
            ],
            [
                null, null, ['gzip']
            ],
            [
                '*', null, []
            ],
            [
                '*', 'identity', ['identity']
            ],
            [
                '*', 'gzip', ['gzip']
            ],
            [
                '*', 'gzip', ['gzip', 'identity']
            ],
            [
                '*, gzip', 'identity', ['identity']
            ],
            [
                '*, gzip', 'gzip', ['gzip']
            ],
            [
                '*, gzip', 'gzip', ['compress', 'gzip']
            ],
            [
                '*, gzip;q=0', 'identity', ['identity']
            ],
            [
                '*, gzip;q=0', null, ['gzip']
            ],
            [
                '*, gzip;q=0', 'compress', ['gzip', 'compress']
            ],
            [
                '*;q=0', null, []
            ],
            [
                '*;q=0', null, ['identity']
            ],
            [
                '*;q=0', null, ['gzip']
            ],
            [
                '*;q=0, identity;q=1', null, []
            ],
            [
                '*;q=0, identity;q=1', 'identity', ['identity']
            ],
            [
                '*;q=0, identity;q=1', null, ['gzip']
            ],
            [
                'identity', null, []
            ],
            [
                'identity', 'identity', ['identity']
            ],
            [
                'identity', null, ['gzip']
            ],
            [
                'identity;q=0', null, []
            ],
            [
                'identity;q=0', null, ['identity']
            ],
            [
                'identity;q=0', null, ['gzip']
            ],
            [
                'gzip', null, []
            ],
            [
                'gzip', 'gzip', ['gzip']
            ],
            [
                'gzip', 'gzip', ['identity', 'gzip']
            ],
            [
                'gzip', 'identity', ['identity']
            ],
            [
                'gzip, compress;q=0', null, ['compress']
            ],
            [
                'gzip, compress;q=0', null, ['deflate', 'compress']
            ],
            [
                'gzip, compress;q=0', 'gzip', ['gzip', 'compress']
            ],
            [
                'gzip, deflate', 'deflate', ['deflate', 'compress']
            ],
            [
                'gzip;q=0.8, deflate', 'gzip', ['gzip']
            ],
            [
                'gzip;q=0.8, deflate', 'deflate', ['deflate']
            ],
            [
                'gzip;q=0.8, deflate', 'deflate', ['deflate', 'gzip']
            ],
            [
                'gzip;q=0.8, identity;q=0.5, *;q=0.3', 'gzip', ['gzip']
            ],
            [
                'gzip;q=0.8, identity;q=0.5, *;q=0.3', 'identity', ['compress', 'identity']
            ]
        ];
    }

    /**
     * accept-encoding , expected
     * @return array
     */
    public function encodingsData()
    {
        return [
            [
                null, ['identity']
            ],
            [
                '*', ['*']
            ],
            [
                '*, gzip', ['*', 'gzip']
            ],
            [
                '*, gzip;q=0', ['*']
            ],
            [
                '*;q=0', []
            ],
            [
                '*;q=0, identity;q=1', ['identity']
            ],
            [
                'identity', ['identity']
            ],
            [
                'identity;q=0', []
            ],
            [
                'gzip', ['gzip', 'identity']
            ],
            [
                'gzip, compress;q=0', ['gzip', 'identity']
            ],
            [
                'gzip, deflate', ['gzip', 'deflate', 'identity']
            ],
            [
                'gzip;q=0.8, deflate', ['deflate', 'gzip', 'identity']
            ],
            [
                'gzip;q=0.8, identity;q=0.5, *;q=0.3', ['gzip', 'identity', '*']
            ]
        ];
    }

    /**
     * accept-encoding, encodings, expected
     * @return array
     */
    public function encodingsArrayData()
    {
        return [
            [
                null, [], []
            ],
            [
                null, ['identity'], ['identity']
            ],
            [
                null, ['gzip'], []
            ],
            [
                '*', [], []
            ],
            [
                '*', ['identity'], ['identity']
            ],
            [
                '*', ['gzip'], ['gzip']
            ],
            [
                '*', ['gzip', 'identity'], ['gzip', 'identity']
            ],
            [
                '*, gzip', ['identity'], ['identity']
            ],
            [
                '*, gzip', ['gzip'], ['gzip']
            ],
            [
                '*, gzip;q=0', ['identity'], ['identity']
            ],
            [
                '*, gzip;q=0', ['gzip'], []
            ],
            [
                '*, gzip;q=0', ['gzip', 'compress'], ['compress']
            ],
            [
                '*;q=0', [], []
            ],
            [
                '*;q=0', ['identity'], []
            ],
            [
                '*;q=0', ['gzip'], []
            ],
            [
                '*;q=0, identity;q=1', [], []
            ],
            [
                '*;q=0, identity;q=1', ['identity'], ['identity']
            ],
            [
                '*;q=0, identity;q=1', ['gzip'], []
            ],
            [
                'identity', [], []
            ],
            [
                'identity', ['identity'], ['identity']
            ],
            [
                'identity', ['gzip'], []
            ],
            [
                'identity;q=0', [], []
            ],
            [
                'identity;q=0', ['identity'], []
            ],
            [
                'identity;q=0', ['gzip'], []
            ],
            [
                'gzip', [], []
            ],
            [
                'gzip', ['GZIP'], ['GZIP']
            ],
            [
                'gzip', ['gzip', 'GZIP'], ['gzip', 'GZIP']
            ],
            [
                'gzip', ['GZIP', 'gzip'], ['GZIP', 'gzip']
            ],
            [
                'gzip', ['gzip'], ['gzip']
            ],
            [
                'gzip', ['gzip', 'identity'], ['gzip', 'identity']
            ],
            [
                'gzip', ['identity', 'gzip'], ['gzip', 'identity']
            ],
            [
                'gzip', ['identity'], ['identity']
            ],
            [
                'gzip, compress;q=0', ['gzip', 'compress'], ['gzip']
            ],
            [
                'gzip, deflate', ['gzip'], ['gzip']
            ],
            [
                'gzip, deflate', ['gzip', 'identity'], ['gzip', 'identity']
            ],
            [
                'gzip, deflate', ['deflate', 'gzip'], ['gzip', 'deflate']
            ],
            [
                'gzip, deflate', ['identity'], ['identity']
            ],
            [
                'gzip;q=0.8, deflate', ['gzip'], ['gzip']
            ],
            [
                'gzip;q=0.8, deflate', ['deflate'], ['deflate']
            ],
            [
                'gzip;q=0.8, deflate', ['deflate', 'gzip'], ['deflate', 'gzip']
            ],
            [
                'gzip;q=0.8, identity;q=0.5, *;q=0.3', ['gzip'], ['gzip']
            ],
            [
                'gzip;q=0.8, identity;q=0.5, *;q=0.3', ['identity', 'gzip', 'compress'], ['gzip', 'identity', 'compress']
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
     * @param $accept_encoding
     * @param $expected
     * @dataProvider encodingData
     */
    public function testEncoding($accept_encoding, $expected)
    {
        $request = self::createRequest(['Accept-Encoding' => $accept_encoding]);
        $negotiator = new Negotiator\Negotiator($request);

        $result = $negotiator->encoding();
        static::assertEquals($expected, $result);
    }

    /**
     * @dataProvider encodingArrayData
     * @param $accept_encoding
     * @param $expected
     * @param $encoding
     */
    public function testEncodingArray($accept_encoding, $expected, $encoding)
    {
        $request = self::createRequest(['Accept-Encoding' => $accept_encoding]);
        $negotiator = new Negotiator\Negotiator($request);

        $result = $negotiator->encoding($encoding);
        static::assertEquals($expected, $result);
    }

    /**
     * @param $accept_encoding
     * @param $expected
     * @dataProvider encodingsData
     */
    public function testEncodings($accept_encoding, $expected)
    {
        $request = self::createRequest(['Accept-Encoding' => $accept_encoding]);
        $negotiator = new Negotiator\Negotiator($request);

        $result = $negotiator->encodings();
        static::assertEquals($expected, $result);
    }


    /**
     * @param $accept_encoding
     * @param $encoding
     * @param $expected
     * @dataProvider encodingsArrayData
     */
    public function testEncodingsArray($accept_encoding, $encoding, $expected)
    {
        $request = self::createRequest(['Accept-Encoding' => $accept_encoding]);
        $negotiator = new Negotiator\Negotiator($request);

        $result = $negotiator->encodings($encoding);
        static::assertEquals($expected, $result);
    }
}
