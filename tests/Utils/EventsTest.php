<?php
declare(strict_types=1);

use Press\Utils\Events;
use PHPUnit\Framework\TestCase;


class EventsTest extends TestCase
{
    private function flattenCheck(array $check)
    {
        $sorted = $check;
        sort($sorted);
        return join(',', $sorted);
    }

    // get_listeners
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
        self::assertEquals($check, $listeners[0]['listener']);
    }

    // flatten_listeners
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

    // add_listener
    public function testAddListenersToSpecifiedEvent()
    {
        $fn1 = function () {
        };
        $ee = new Events();
        $ee->add_listener('foo', $fn1);
        $listeners = $ee->get_listeners('foo');
        $result = $ee->flatten_listeners($listeners);
        self::assertEquals([$fn1], $result);
    }

    public function testNotAllowDuplicateListeners()
    {

        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $ee = new Events();
        $ee->add_listener('bar', $fn1);
        $result = $ee->get_listeners('bar');
        self::assertEquals([$fn1], $ee->flatten_listeners($result));
        $ee->add_listener('bar', $fn2);
        $result = $ee->get_listeners('bar');
        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($result));
        $ee->add_listener('bar', $fn1);
        $result = $ee->get_listeners('bar');
        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($result));

    }

    public function testAllowsToAddListenersByRegex()
    {
        $check = [];
        $ee = new Events();

        $ee->define_events(['bar', 'baz']);
        $ee->add_listener('foo', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('/ba[rz]/', function () use (&$check) {
            array_push($check, 2);
        });
        $ee->emit_event('/ba[rz]/');

        $result = $this->flattenCheck($check);
        self::assertEquals('2,2', $result);
    }

    public function testPreventsYouFromAddingDuplicateListeners()
    {
        $count = 0;

        $adder = function () use (&$count) {
            $count += 1;
        };

        $ee = new Events();

        $ee->add_listener('foo', $adder);
        $ee->add_listener('foo', $adder);
        $ee->add_listener('foo', $adder);
        $ee->emit_event('foo');

        self::assertEquals(1, $count);
    }

    /**
     * @expectedException TypeError
     */
    public function testThrowErrorWhenTryToAddNonFunctionOrRegexListenerWhenNull()
    {
        $ee = new Events();
        $ee->add_listener('foo', null);
    }

    /**
     * @expectedException TypeError
     */
    public function testThrowErrorWhenTryToAddNonFunctionOrRegexListenerWhenNone()
    {
        $ee = new Events();
        $ee->add_listener('foo');
    }

    /**
     * @expectedException TypeError
     */
    public function testThrowErrorWhenTryToAddNonFunctionOrRegexListenerWhenString()
    {
        $ee = new Events();
        $ee->add_listener('foo', 'lol');
    }

    // add_once_listener
    public function testOnceListenersCanBeAdded()
    {
        $ee = new Events();
        $fn1 = function () {};
        $ee->add_once_listener('foo', $fn1);
        self::assertEquals([$fn1], $ee->flatten_listeners($ee->get_listeners('foo')));
    }

    public function testListenersAreOnlyExecOnce()
    {
        $ee = new Events();
        $counter = 0;
        $fn1 = function () use (&$counter) {
            $counter++;
        };

        $ee->add_once_listener('foo', $fn1);
        $ee->emit_event('foo');
        $ee->emit_event('foo');
        $ee->emit_event('foo');
        self::assertEquals(1, $counter);
    }

    public function testListenersCanBeRemoved()
    {
        $ee = new Events();
        $counter = 0;
        $fn1 = function () use (&$counter) {
            $counter++;
        };

        $ee->add_once_listener('foo', $fn1);
        $ee->remove_listener('foo', $fn1);

        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('foo')));
    }

    public function testCanNotCauseInfiniteRecursion()
    {
        $ee = new Events();
        $counter = 0;

        $ee->add_once_listener('foo', function () use (&$counter, &$ee) {
            $counter++;
            $ee->emit_event('foo');
        });
        $ee->trigger('foo');
        self::assertEquals(1, $counter);
    }

    // remove listener
    public function testDoNothingWhenListenerNotFound()
    {
        $ee = new Events();
        $orig = count($ee->get_listeners('foo'));

        $fn1 = function () {};
        $ee->remove_listener('foo', $fn1);
        self::assertEquals($orig, count($ee->get_listeners('foo')));
    }

    //todo: 待填补
    public function testCanHandleRemovingEventsThatHaveNotBeenAdded()
    {
        $ee = new Events();
    }

    public function testActuallyRemovesEvents()
    {
        $ee = new Events();
        $ee->remove_event('foo');
    }
}
