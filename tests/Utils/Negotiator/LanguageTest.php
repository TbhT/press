<?php
declare(strict_types=1);

use Press\Request;
use Press\Utils\Negotiator\Language;
use PHPUnit\Framework\TestCase;
use Press\Utils\Negotiator\Negotiator;


class LanguageTest extends TestCase
{

    /**
     * accept-language, expected
     * @return array
     */
    public function languageData()
    {
        return [
            [
                null, '*'
            ],
            [
                '*', '*'
            ],
            [
                '*, en', '*'
            ],
            [
                '*, en;q=0', '*'
            ],
            [
                '*;q=0.8, en, es', 'en'
            ],
            [
                'en', 'en'
            ],
            [
                'en;q=0', null
            ],
            [
                'en;q=0.8, es', 'es'
            ],
            [
                'en;q=0.9, es;q=0.8; en;q=0.7', 'en'
            ],
            [
                'en-US, en;q=0.8', 'en-US'
            ],
            [
                'en-US, en-GB', 'en-US'
            ],
            [
                'en-US;q=0.8, es', 'es'
            ],
            [
                'nl;q=0.5, fr, de, en, it, es, pt, no, se, fi, ro', 'fr'
            ]
        ];
    }

    /**
     * accept-language, language, expect
     * @return array
     */
    public function languageArrayData()
    {
        return [
            [
                null, [], null
            ],
            [
                null, ['en'], 'en'
            ],
            [
                null, ['es', 'en'], 'es'
            ],
            [
                '*', [], null
            ],
            [
                '*', ['en'], 'en'
            ],
            [
                '*', ['es', 'en'], 'es'
            ],
            [
                '*, en', [], null
            ],
            [
                '*, en', ['en'], 'en'
            ],
            [
                '*, en', ['es', 'en'], 'en'
            ],
            [
                '*, en;q=0', [], null
            ],
            [
                '*, en;q=0', ['en'], null
            ],
            [
                '*, en;q=0', ['es', 'en'], 'es'
            ],
            [
                '*;q=0.8, en, es', ['en', 'nl'], 'en'
            ],
            [
                '*;q=0.8, en, es', ['ro', 'nl'], 'ro'
            ],
            [
                'en', [], null
            ],
            [
                'en', ['en'], 'en'
            ],
            [
                'en', ['es', 'en'], 'en'
            ],
            [
                'en', ['en-US'], 'en-US'
            ],
            [
                'en', ['en-US', 'en'], 'en'
            ],
            [
                'en', ['en', 'en-US'], 'en'
            ],
            [
                'en;q=0', [], null
            ],
            [
                'en;q=0', ['es', 'en'], null
            ],
            [
                'en;q=0.8, es', [], null
            ],
            [
                'en;q=0.8, es', ['en'], 'en'
            ],
            [
                'en;q=0.8, es', ['en', 'es'], 'es'
            ],
            [
                'en;q=0.9, es;q=0.8, en;q=0.7', ['es'], 'es'
            ],
            [
                'en;q=0.9, es;q=0.8, en;q=0.7', ['en', 'es'], 'en'
            ],
            [
                'en;q=0.9, es;q=0.8, en;q=0.7', ['es', 'en'], 'en'
            ],
            [
                'en-US, en;q=0.8', ['en', 'en-US'], 'en-US'
            ],
            [
                'en-US, en;q=0.8', ['en-GB', 'en-US'], 'en-US'
            ],
            [
                'en-US, en;q=0.8', ['en-GB', 'es'], 'en-GB'
            ],
            [
                'en-US, en-GB', ['en-US', 'en-GB'], 'en-US'
            ],
            [
                'en-US, en-GB', ['en-GB', 'en-US'], 'en-US'
            ],
            [
                'en-US, en-GB', ['en-US', 'en-GB'], 'en-US'
            ],
            [
                'en-US, en-GB', ['en-GB', 'en-US'], 'en-US'
            ],
            [
                'en-US;q=0.8, es', ['es', 'en-US'], 'es'
            ],
            [
                'en-US;q=0.8, es', ['en-US', 'es'], 'es'
            ],
            [
                'en-US;q=0.8, es', ['en-US', 'en'], 'en-US'
            ],
            [
                'nl;q=0.5, fr, de, en, it, es, pt, no, se, fi, ro', ['nl', 'fr'], 'fr'
            ]
        ];
    }

    /**
     * accept-language, expect
     * @return array
     */
    public function languagesData()
    {
        return [
            [
                null, ['*']
            ],
            [
                '*', ['*']
            ],
            [
                '*, en', ['*', 'en']
            ],
            [
                '*, en;q=0', ['*']
            ],
            [
                '*;q=0.8, en, es', ['en', 'es', '*']
            ],
            [
                'en', ['en']
            ],
            [
                'en;q=0', []
            ],
            [
                'en;q=0.8, es', ['es', 'en']
            ],
            [
                'en;q=0.9, es;q=0.8, en;q=0.7', ['en', 'es']
            ],
            [
                'en-US, en;q=0.8', ['en-US', 'en']
            ],
            [
                'en-US, en-GB', ['en-US', 'en-GB']
            ],
            [
                'en-US;q=0.8, es', ['es', 'en-US']
            ],
            [
                'nl;q=0.5, fr, de, en, it, es, pt, no, se, fi, ro', ['fr', 'de', 'en', 'it', 'es', 'pt', 'no', 'se', 'fi', 'ro', 'nl']
            ]
        ];
    }

    /**
     * accept-language, languages, expect
     * @return array
     */
    public function languagesArrayData()
    {
        return [
//            [
//                null, ['en'], ['en']
//            ],
//            [
//                null, ['es', 'en'], ['es', 'en']
//            ],
//            [
//                '*', ['en'], ['en']
//            ],
//            [
//                '*', ['es', 'en'], ['es', 'en']
//            ],
//            [
//                '*, en', ['en'], ['en']
//            ],
//            [
//                '*, en', ['es', 'en'], ['en', 'es']
//            ],
//            [
//                '*, en;q=0', ['en'], []
//            ],
//            [
//                '*, en;q=0', ['es', 'en'], ['es']
//            ],
//            [
//                '*;q=0.8, en, es',
//                ['fr', 'de', 'en', 'it', 'es', 'pt', 'no', 'se', 'fi', 'ro', 'nl'],
//                ['en', 'es', 'fr', 'de', 'it', 'pt', 'no', 'se', 'fi', 'ro', 'nl']
//            ],
//            [
//                'en', ['en'], ['en']
//            ],
//            [
//                'en', ['en', 'es'], ['en']
//            ],
//            [
//                'en', ['es', 'en'], ['en']
//            ],
//            [
//                'en', ['en-US'], ['en-US']
//            ],
//            [
//                'en', ['en-US', 'en'], ['en', 'en-US']
//            ],
//            [
//                'en', ['en', 'en-US'], ['en', 'en-US']
//            ],
//            [
//                'en;q=0', ['en'], []
//            ],
//            [
//                'en;q=0', ['en', 'es'], []
//            ],
//            [
//                'en;q=0.8, es', ['en'], ['en']
//            ],
//            [
//                'en;q=0.8, es', ['en', 'es'], ['es', 'en']
//            ],
//            [
//                'en;q=0.8, es', ['es', 'en'], ['es', 'en']
//            ],
//            [
//                'en;q=0.9, es;q=0.8, en;q=0.7', ['en'], ['en']
//            ],
//            [
//                'en;q=0.9, es;q=0.8, en;q=0.7', ['en', 'es'], ['en', 'es']
//            ],
//            [
//                'en;q=0.9, es;q=0.8, en;q=0.7', ['es', 'en'], ['en', 'es']
//            ],
//            [
//                'en-US, en;q=0.8', ['en-us', 'EN'], ['en-us', 'EN']
//            ],
//            [
//                'en-US, en;q=0.8', ['en-US', 'en'], ['en-US', 'en']
//            ],
            [
                'en-US, en;q=0.8', ['en-GB', 'en-US', 'en'], ['en-US', 'en', 'en-GB']
            ],
//            [
//                'en-US, en-GB', ['en-US', 'en-GB'], ['en-US', 'en-GB']
//            ],
            [
                'en-US, en-GB', ['en-GB', 'en-US'], ['en-GB', 'en-US']
            ],
            [
                'en-US;q=0.8, es', ['en', 'es'], ['en', 'es']
            ],
            [
                'en-US;q=0.8, es', ['en', 'es', 'en-US'], ['en', 'es', 'en-US']
            ],
//            [
//                'nl;q=0.5, fr, de, en, it, es, pt, no, se, fi, ro',
//                ['fr', 'de', 'en', 'it', 'es', 'pt', 'no', 'se', 'fi', 'ro', 'nl'],
//                ['fr', 'de', 'en', 'it', 'es', 'pt', 'no', 'se', 'fi', 'ro', 'nl']
//            ]
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
     * @dataProvider languageData
     * @param $accept_language
     * @param $expect
     */
    public function testLanguage($accept_language, $expect)
    {
        $request = self::createRequest(['Accept-Language' => $accept_language]);
        $negotiator = new Negotiator($request);

        $result = $negotiator->language();
        static::assertEquals($expect, $result);
    }

    /**
     * @dataProvider languageArrayData
     * @param $accept_language
     * @param $language
     * @param $expected
     */
    public function testLanguageArray($accept_language, $language, $expected)
    {
        $request = self::createRequest(['Accept-Language' => $accept_language]);
        $negotiator = new Negotiator($request);

        $result = $negotiator->language($language);
        static::assertEquals($expected, $result);
    }

    /**
     * @dataProvider languagesData
     * @param $accept_language
     * @param $expected
     */
    public function testLanguages($accept_language, $expected)
    {
        $request = self::createRequest(['Accept-Language' => $accept_language]);
        $negotiator = new Negotiator($request);

        $result = $negotiator->languages();
        static::assertEquals($expected, $result);
    }

    /**
     * @dataProvider languagesArrayData
     * @param $accept_language
     * @param $language
     * @param $expected
     */
//    todo 这个地方需要修改
    public function testLanguagesArray($accept_language, $language, $expected)
    {
        $request = self::createRequest(['Accept-Language' => $accept_language]);
        $negotiator = new Negotiator($request);

        $result = $negotiator->languages($language);
        static::assertEquals($expected, $result);
    }
}
