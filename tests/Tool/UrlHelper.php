<?php

declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use Press\Helper\UrlHelper;


class UrlHelperTest extends TestCase
{

    /**
     * An array of test cases with expected inputs and outputs. the format of each array item is :
     *
     *  ["path", "expected params", "route", "expected output", "options"]
     *
     * @type {array}
     * @return array
     */


    public function simplePaths()
    {
        return [
            ['/', [], '/', ['/']],
            ['/test', [], '/test', ['/test']],
            ['/test', [], '/route', null],
            ['/test', [], '/test/route', null],
            ['/test', [], '/test/', ['/test/']],
            ['/test/', [], '/test', ['/test']],
            ['/test/', [], '/test/', ['/test/']],
            ['/test/', [], '/test//', null],
        ];
    }

    public function caseSensitivePaths()
    {
        return [
            ['/test', [], '/test', ['/test'], ['sensitive' => true]],
            ['/test', [], '/TEST', null, ['sensitive' => true]],
            ['/TEST', [], '/test', null, ['sensitive' => true]]
        ];
    }

    public function strictMode()
    {
        return [
            ['/test', [], '/test', ['/test'], ['strict' => true]],
            ['/test', [], '/test/', null, ['strict' => true]],
            ['/test/', [], '/test', null, ['strict' => true]],
            ['/test/', [], '/test/', ['/test/'], ['strict' => true]],
            ['/test/', [], '/test//', null, ['strict' => true]]
        ];
    }

    public function nonEndingMode()
    {
        return [
            ['/test', [], '/test', ['/test'], ['end' => false]],
            ['/test', [], '/test/', ['/test/'], ['end' => false]],
            ['/test', [], '/test/route', ['/test'], ['end' => false]],
            ['/test/', [], '/test/route', ['/test'], ['end' => false]],
            ['/test/', [], '/test//', ['/test'], ['end' => false]],
            ['/test/', [], '/test//route', ['/test'], ['end' => false]],
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route',
                ['/route', 'route'],
                ['end' => false]
            ],
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route',
                ['/route', 'route'],
                ['end' => false]
            ]
        ];
    }

    public function combineMode()
    {
        return [
            ['/test', [], '/test', ['/test'], ['end' => false, 'strict' => true]],
            ['/test', [], '/test/', ['/test'], ['end' => false, 'strict' => true]],
            ['/test', [], '/test/route', ['/test'], ['end' => false, 'strict' => true]],
            ['/test/', [], '/test', null, ['end' => false, 'strict' => true]],
            ['/test/', [], '/test/', ['/test/'], ['end' => false, 'strict' => true]],
            ['/test/', [], '/test//', ['/test/'], ['end' => false, 'strict' => true]],
            ['/test/', [], '/test/route', ['/test/'], ['end' => false, 'strict' => true]],
            ['/test.json', [], '/test.json', ['/test.json'], ['end' => false, 'strict' => true]],
            ['/test.json', [], '/test.json.hbs', null, ['end' => false, 'strict' => true]],
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route',
                ['/route', 'route'],
                ['end' => false, 'strict' => true]
            ],
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route/',
                ['/route', 'route'],
                ['end' => false, 'strict' => true]
            ],
            [
                '/:test/',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route/',
                ['/route/', 'route'],
                ['end' => false, 'strict' => true]
            ],
            [
                '/:test/',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route',
                null,
                ['end' => false, 'strict' => true]
            ]
        ];
    }

    public function arrayOfSimplePath()
    {
        return [
            [['/one', '/two'], [], '/one', ['/one']],
            [['/one', '/two'], [], '/two', ['/two']],
            [['/one', '/two'], [], '/three', null],
            [['/one', '/two'], [], '/one/two', null]
        ];
    }

    public function nonEndingSimplePath()
    {
        return [
            ['/test', [], '/test/route', ['/test'], ['end' => false]]
        ];
    }

    public function singleNamedParameter()
    {
        return [
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route',
                ['/route', 'route']
            ],
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/another',
                ['/another', 'another']
            ],
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/something/else',
                null
            ],
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route.json',
                ['/route.json', 'route.json']
            ],
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route',
                ['/route', 'route'],
                ['strict' => true],],
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route/',
                null,
                ['strict' => true],
            ],
            [
                '/:test/',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route/',
                ['/route/', 'route'],
                ['strict' => true],
            ],
            [
                '/:test/',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route//',
                null,
                ['strict' => true],
            ],
            [
                '/:test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route.json',
                ['/route.json', 'route.json'],
                ['end' => false]
            ],
        ];
    }

    public function optionalNamedParameter()
    {
        return [
            [
                '/:test?',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => false]],
                '/route',
                ['/route', 'route']
            ],
            [
                '/:test?',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => false]],
                '/route/nested',
                null
            ],
            [
                '/:test?',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => false]],
                '/',
                ['/', null]
            ],
            [
                '/:test?',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => false]],
                '/route',
                ['/route', 'route'],
                ['strict' => true]
            ],
            [
                '/:test?',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => false]],
                '/',
                null, // Questionable behaviour.
                ['strict' => true]
            ],
            [
                '/:test?/',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => false]],
                '/',
                ['/', null],
                ['strict' => true]
            ],
            [
                '/:test?/',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => false]],
                '//',
                null
            ],
            [
                '/:test?/',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => false]],
                '//',
                null,
                ['strict' => true]
            ],

        ];
    }

    public function repeatedOnceOrMoreTimesParameters()
    {
        return [
            [
                '/:test+',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => true]],
                '/',
                null
            ],
            [
                '/:test+',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => true]],
                '/route',
                ['/route', 'route']
            ],
            [
                '/:test+',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => true]],
                '/some/basic/route',
                ['/some/basic/route', 'some/basic/route']
            ],
            [
                '/:test(\\d+)+',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => true]],
                '/abc/456/789',
                null
            ],
            [
                '/:test(\\d+)+',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => true]],
                '/123/456/789',
                ['/123/456/789', '123/456/789']
            ],
            [
                '/route.:ext(json|xml)+',
                [['name' => 'ext', 'delimiter' => '.', 'optional' => false, 'repeat' => true]],
                '/route.json',
                ['/route.json', 'json']
            ],
            [
                '/route.:ext(json|xml)+',
                [['name' => 'ext', 'delimiter' => '.', 'optional' => false, 'repeat' => true]],
                '/route.xml.json',
                ['/route.xml.json', 'xml.json']
            ],
            [
                '/route.:ext(json|xml)+',
                [['name' => 'ext', 'delimiter' => '.', 'optional' => false, 'repeat' => true]],
                '/route.html',
                null
            ]
        ];
    }

    public function repeatedZeroOrMoreTimesParameters()
    {
        return [
            [
                '/:test*',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => true]],
                '/',
                ['/', null]
            ],
            [
                '/:test*',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => true]],
                '//',
                null
            ],
            [
                '/:test*',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => true]],
                '/route',
                ['/route', 'route']
            ],
            [
                '/:test*',
                [['name' => 'test', 'delimiter' => '/', 'optional' => true, 'repeat' => true]],
                '/some/basic/route',
                ['/some/basic/route', 'some/basic/route']
            ],
            [
                '/route.:ext([a-z]+)*',
                [['name' => 'ext', 'delimiter' => '.', 'optional' => true, 'repeat' => true]],
                '/route',
                ['/route', null]
            ],
            [
                '/route.:ext([a-z]+)*',
                [['name' => 'ext', 'delimiter' => '.', 'optional' => true, 'repeat' => true]],
                '/route.json',
                ['/route.json', 'json']
            ],
            [
                '/route.:ext([a-z]+)*',
                [['name' => 'ext', 'delimiter' => '.', 'optional' => true, 'repeat' => true]],
                '/route.xml.json',
                ['/route.xml.json', 'xml.json']
            ],
            [
                '/route.:ext([a-z]+)*',
                [['name' => 'ext', 'delimiter' => '.', 'optional' => true, 'repeat' => true]],
                '/route.123',
                null
            ],
        ];
    }

    public function customNamedParameters()
    {
        return [
            [
                '/:test(\\d+)',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/123',
                ['/123', '123']
            ],
            [
                '/:test(\\d+)',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/abc',
                null
            ],
            [
                '/:test(\\d+)',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/123/abc',
                null
            ],
            [
                '/:test(\\d+)',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/123/abc',
                ['/123', '123'],
                ['end' => false],
            ],
            [
                '/:test(.*)',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/anything/goes/here',
                ['/anything/goes/here', 'anything/goes/here']
            ],
            [
                '/:route([a-z]+)',
                [['name' => 'route', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/abcde',
                ['/abcde', 'abcde']
            ],
            [
                '/:route([a-z]+)',
                [['name' => 'route', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/12345',
                null
            ],
            [
                '/:route(this|that)',
                [['name' => 'route', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/this',
                ['/this', 'this']
            ],
            [
                '/:route(this|that)',
                [['name' => 'route', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/that',
                ['/that', 'that']
            ],
        ];
    }

    public function prefixedSlashes()
    {
        return [
            [
                'test',
                [],
                'test',
                ['test']
            ],
            [
                ':test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                'route',
                ['route', 'route']
            ],
            [
                ':test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route',
                null
            ],
            [
                ':test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                'route/',
                ['route/', 'route']
            ],
            [
                ':test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                'route/',
                null,
                ['strict' => true]
            ],
            [
                ':test',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                'route/',
                ['route/', 'route'],
                ['end' => false],
            ],

        ];
    }

    public function formats()
    {
        return [
            [
                '/test.json', [], '/test.json', ['/test.json']
            ],
            [
                '/test.json', [], '/route.json', null
            ],
            [
                '/:test.json',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route.json',
                ['/route.json', 'route']
            ],
            [
                '/:test.json',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route.json.json',
                ['/route.json.json', 'route.json']
            ],
            [
                '/:test.json',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route.json',
                ['/route.json', 'route'],
                ['end' => false]
            ],
            [
                '/:test.json',
                [['name' => 'test', 'delimiter' => '/', 'optional' => false, 'repeat' => false]],
                '/route.json.json',
                ['/route.json.json', 'route.json'],
                ["end" => false]
            ]
        ];
    }

    public function formatParams()
    {
        return [
            [
                '/test.:format',
                [['name' => 'format', 'delimiter' => '.', 'optional' => false, 'repeat' => false]],
                '/test.html',
                ['/test.html', 'html']
            ],
            [
                '/test.:format.:format',
                [
                    ['name' => 'format', 'delimiter' => '.', 'optional' => false, 'repeat' => false],
                    ['name' => 'format', 'delimiter' => '.', 'optional' => false, 'repeat' => false]
                ],
                '/test.hbs.html',
                [
                    '/test.hbs.html', 'hbs', 'html'
                ]
            ],
            [
                '/test.:format',
                [
                    ['name' => 'format', 'delimiter' => '.', 'optional' => false, 'repeat' => false]
                ],
                '/test.hbs.html',
                null
            ],
            [
                '/test.:format+',
                [["name" => 'format', "delimiter" => '.', "optional" => false, "repeat" => true]],
                '/test.hbs.html',
                ['/test.hbs.html', 'hbs.html']
            ],
            [
                '/test.:format',
                [["name" => 'format', "delimiter" => '.', "optional" => false, "repeat" => false]],
                '/test.hbs.html',
                null,
                ["end" => false]
            ],
            [
                '/test.:format.',
                [["name" => 'format', "delimiter" => '.', "optional" => false, "repeat" => false]],
                '/test.hbs.html',
                null,
                ["end" => false]
            ]
        ];
    }

    public function formatAndPathParams()
    {
        return [
            [
                '/:test.:format',
                [
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'format', "delimiter" => '.', "optional" => false, "repeat" => false]
                ],
                '/route.html',
                ['/route.html', 'route', 'html']
            ],
            [
                '/:test.:format',
                [
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'format', "delimiter" => '.', "optional" => false, "repeat" => false]
                ],
                '/route',
                null
            ],
            [
                '/:test.:format',
                [
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'format', "delimiter" => '.', "optional" => false, "repeat" => false]
                ],
                '/route',
                null
            ],
            [
                '/:test.:format?',
                [
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'format', "delimiter" => '.', "optional" => true, "repeat" => false]
                ],
                '/route',
                ['/route', 'route', null]
            ],
            [
                '/:test.:format?',
                [
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'format', "delimiter" => '.', "optional" => true, "repeat" => false]
                ],
                '/route.json',
                ['/route.json', 'route', 'json']
            ],
            [
                '/:test.:format?',
                [
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'format', "delimiter" => '.', "optional" => true, "repeat" => false]
                ],
                '/route',
                ['/route', 'route', null],
                ["end" => false]
            ],
            [
                '/:test.:format?',
                [
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'format', "delimiter" => '.', "optional" => true, "repeat" => false]
                ],
                '/route.json',
                ['/route.json', 'route', 'json'],
                ["end" => false]
            ],
            [
                '/:test.:format?',
                [
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'format', "delimiter" => '.', "optional" => true, "repeat" => false]
                ],
                '/route.json.html',
                ['/route.json.html', 'route.json', 'html'],
                ["end" => false]
            ],
            [
                '/test.:format(.*)z',
                [
                    ["name" => 'format', "delimiter" => '.', "optional" => false, "repeat" => false]
                ],
                '/test.abc',
                null,
                ["end" => false]
            ],
            [
                '/test.:format(.*)z',
                [
                    ["name" => 'format', "delimiter" => '.', "optional" => false, "repeat" => false]
                ],
                '/test.abcz',
                ['/test.abcz', 'abc'],
                ["end" => false]
            ]
        ];
    }

    public function unnamedParams()
    {
        return [
            [
                '/(\\d+)',
                [["name" => '0', "delimiter" => '/', "optional" => false, "repeat" => false]],
                '/123',
                ['/123', '123']
            ],
            [
                '/(\\d+)',
                [["name" => '0', "delimiter" => '/', "optional" => false, "repeat" => false]],
                '/abc',
                null
            ],
            [
                '/(\\d+)',
                [["name" => '0', "delimiter" => '/', "optional" => false, "repeat" => false]],
                '/123/abc',
                null
            ],
            [
                '/(\\d+)',
                [["name" => '0', "delimiter" => '/', "optional" => false, "repeat" => false]],
                '/123/abc',
                ['/123', '123'],
                ["end" => false]
            ],
            [
                '/(\\d+)',
                [["name" => '0', "delimiter" => '/', "optional" => false, "repeat" => false]],
                '/abc',
                null,
                ["end" => false]
            ],
            [
                '/(\\d+)?',
                [["name" => '0', "delimiter" => '/', "optional" => true, "repeat" => false]],
                '/',
                ['/', null]
            ],
            [
                '/(\\d+)?',
                [["name" => '0', "delimiter" => '/', "optional" => true, "repeat" => false]],
                '/123',
                ['/123', '123']
            ],
            [
                '/(.*)',
                [["name" => '0', "delimiter" => '/', "optional" => false, "repeat" => false]],
                '/route',
                ['/route', 'route']
            ],
            [
                '/(.*)',
                [["name" => '0', "delimiter" => '/', "optional" => false, "repeat" => false]],
                '/route/nested',
                ['/route/nested', 'route/nested']
            ]
        ];
    }

    public function correctNamesAndIndexes()
    {
        return [
            [
                ['/:test', '/route/:test'],
                [
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false]
                ],
                '/test',
                ['/test', 'test', null]
            ],
            [
                ['/:test', '/route/:test'],
                [
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'test', "delimiter" => '/', "optional" => false, "repeat" => false]
                ],
                '/route/test',
                ['/route/test', null, 'test']
            ]
        ];
    }

    public function respectEscapedCharacters()
    {
        return [
//            ['/\\(testing\\)', [], '/testing', null],
//            ['/\\(testing\\)', [], '/(testing)', ['/(testing)']],
            ['/.+*?=^!:${}[]|', [], '/.+*?=^!:${}[]|', ['/.+*?=^!:${}[]|']]
        ];
    }

    public function regressions()
    {
        return [
            [
                '/:remote([\\w-.]+)/:user([\\w-]+)',
                [
                    ["name" => 'remote', "delimiter" => '/', "optional" => false, "repeat" => false],
                    ["name" => 'user', "delimiter" => '/', "optional" => false, "repeat" => false]
                ],
                '/endpoint/user',
                ['/endpoint/user', 'endpoint', 'user']
            ]
        ];
    }


    private static function main($path, $expected_params, $route, $expected_output, $options = [], $func_name)
    {
        $params = [];
        $regexp = UrlHelper::pathToRegExp($path, $params, $options);

        static::assertEquals($expected_params, $params);
        $matches = UrlHelper::match($regexp, $route);

        self::assertEquals($expected_output, $matches);
    }


    /**
     * @dataProvider simplePaths
     */
    public function testSimplePaths($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }


    /**
     * @dataProvider caseSensitivePaths
     */
    public function testCaseSensitivePaths($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }


    /**
     * @dataProvider strictMode
     */
    public function testStrictMode($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }


    /**
     * @dataProvider nonEndingMode
     */
    public function testNonEndingMode($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider combineMode
     */
    public function testCombineMode($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider arrayOfSimplePath
     */
    public function testArrayOfSimplePath($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider nonEndingSimplePath
     */
    public function testNonEndingSimplePath($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider singleNamedParameter
     */
    public function testSingleNamedParameter($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider optionalNamedParameter
     */
    public function testOptionalNamedParameter($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider repeatedOnceOrMoreTimesParameters
     */
    public function testRepeatedOnceOrMoreTimesParameters($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider repeatedZeroOrMoreTimesParameters
     */
    public function testRepeatedZeroOrMoreTimesParameters($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider customNamedParameters
     */
    public function testCustomNamedParameters($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider prefixedSlashes
     */
    public function testPrefixedSlashes($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider formats
     */
    public function testFormats($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider formatParams
     */
    public function testFormatParams($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider formatAndPathParams
     */
    public function testFormatAndPathParams($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider unnamedParams
     */
    public function testUnnamedParams($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider correctNamesAndIndexes
     */
    public function testCorrectNamesAndIndexes($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider respectEscapedCharacters
     */
    public function testRespectEscapedCharacters($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

    /**
     * @dataProvider regressions
     */
    public function testRegressions($path, $expected_params, $route, $expected_output, $options = [])
    {
        static::main($path, $expected_params, $route, $expected_output, $options, __FUNCTION__);
    }

}