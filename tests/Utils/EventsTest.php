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
}
