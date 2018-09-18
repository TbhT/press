<?php
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-9-16
 * Time: 上午10:39
 */

use Press\Utils\Events;
use PHPUnit\Framework\TestCase;


class EventsTest extends TestCase
{
    public function testShouldInitialisesEventObjectAndAListenerArray()
    {
        $ee = new Events();
        $listener = $ee->get_listeners('foo');
        self::assertEquals([], $listener);
    }

    public function testNotOverwriteListenerArrays()
    {
        $ee = new Events();
        $listeners = $ee->get_listeners('foo');
        array_push($listeners, 'bar');

        self::assertEquals(['bar'], $listeners);
        $ee->get_listeners('foo');
        self::assertEquals(['bar'], $listeners);

    }

    public function testAllowToFetchListenersByRegex()
    {
        $check = [];
        $ee = new Events();

        $ee->add_listener('foo', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('bar', function () use (&$check) {
            array_push($check, 2);
            return 'bar';
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 3);
            return 'baz';
        });

        $listeners = $ee->get_listeners('/ba[rz]/');

        self::assertEquals(2, count($listeners['bar']) + count($listeners['baz']));
        self::assertEquals('bar', $listeners['bar'][0]['listener']());
        self::assertEquals('baz', $listeners['baz'][0]['listener']());
    }

    public function testNotReturnMatchedSubstring()
    {
        $check = function () {
        };
        $ee = new Events();

        $ee->add_listener('foo', function () {

        });

        $ee->add_listener('fooBar', $check);

        $listeners = $ee->get_listeners('fooBar');
        self::assertEquals(1, count($listeners));
        self::assertEquals($check, $listeners['fooBar'][0]['listener']);
    }

    public function testTakesArrayOfArrayAndReturnArrayOfFn()
    {
        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };

        $ee = new Events();
        $input = [
            ['listener' => $fn1],
            ['listener' => $fn2],
            ['listener' => $fn3]
        ];
        $output = $ee->flatten_listeners($input);
        self::assertEquals([$fn1, $fn2, $fn3], $output);
    }

    public function testGivenAnEmptyArrayAndAnEmptyArrayReturned()
    {
        $ee = new Events();
        $output = $ee->flatten_listeners([]);
        self::assertEquals([], $output);
    }

    public function testAddListenersToSpecifiedEvent()
    {
        $fn1 = function () {
        };
        $ee = new Events();
        $ee->add_listener('foo', $fn1);
        $listeners = $ee->get_listeners('foo');
        $result = $ee->flatten_listeners($listeners['foo']);
        self::assertEquals([$fn1], $result);
    }
}
