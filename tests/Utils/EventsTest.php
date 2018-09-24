<?php
declare(strict_types=1);

use Press\Utils\Events;
use PHPUnit\Framework\TestCase;


function arrays_are_similar($a, $b)
{
    foreach ($a as $k => $v) {
        if ($v !== $b[$k]) {
            return false;
        }
    }

    return true;
}


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
        self::assertTrue(arrays_are_similar([$fn1, $fn2, $fn3], $output));
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
        self::assertTrue(arrays_are_similar([$fn1], $result));
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
        self::assertTrue(arrays_are_similar([$fn1], $ee->flatten_listeners($result)));

        $ee->add_listener('bar', $fn2);
        $result = $ee->get_listeners('bar');
        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($result));
        self::assertTrue(arrays_are_similar([$fn1, $fn2], $ee->flatten_listeners($result)));

        $ee->add_listener('bar', $fn1);
        $result = $ee->get_listeners('bar');
        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($result));
        self::assertTrue(arrays_are_similar([$fn1, $fn2], $ee->flatten_listeners($result)));

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
        $fn1 = function () {
        };
        $ee->add_once_listener('foo', $fn1);
        self::assertEquals([$fn1], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn1], $ee->flatten_listeners($ee->get_listeners('foo'))));
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

        $fn1 = function () {
        };
        $ee->remove_listener('foo', $fn1);
        self::assertEquals($orig, count($ee->get_listeners('foo')));
    }

    public function testCanHandleRemovingEventsThatHaveNotBeenAdded()
    {
        $ee = new Events();
        $reflector = new ReflectionClass('\Press\Utils\Events');
        self::assertTrue($reflector->hasProperty('events'));
    }

    public function testActuallyRemovesEvents()
    {
        $ee = new Events();
        $ee->remove_event('foo');
        $reflector = new ReflectionClass('\Press\Utils\Events');
        self::assertEquals(true, $reflector->hasProperty('events'));
    }

    public function testRemoveListeners()
    {
        $ee = new Events();

        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };
        $fn4 = function () {
        };
        $fnx = function () {
        };

        $ee->add_listener('bar', $fn1);
        $ee->add_listener('bar', $fn2);
        $ee->add_listener('bar', $fn3);
        // make sure doubling up does nothing
        $ee->add_listener('bar', $fn3);
        $ee->add_listener('bar', $fn4);

        self::assertEquals([$fn1, $fn2, $fn3, $fn4], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertTrue(arrays_are_similar([$fn1, $fn2, $fn3, $fn4], $ee->flatten_listeners($ee->get_listeners('bar'))));

        $ee->remove_listener('bar', $fn3);
        self::assertEquals([$fn1, $fn2, $fn4], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertTrue(arrays_are_similar([$fn1, $fn2, $fn4], $ee->flatten_listeners($ee->get_listeners('bar'))));

        $ee->remove_listener('bar', $fnx);
        self::assertEquals([$fn1, $fn2, $fn4], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertTrue(arrays_are_similar([$fn1, $fn2, $fn4], $ee->flatten_listeners($ee->get_listeners('bar'))));

        $ee->remove_listener('bar', $fn1);
        self::assertEquals([$fn2, $fn4], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertTrue(arrays_are_similar([$fn2, $fn4], $ee->flatten_listeners($ee->get_listeners('bar'))));

        $ee->remove_listener('bar', $fn4);
        self::assertEquals([$fn2], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertTrue(arrays_are_similar([$fn2], $ee->flatten_listeners($ee->get_listeners('bar'))));

        $ee->remove_listener('bar', $fn2);
        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('bar')));
    }

    public function testRemovesWithRegex()
    {
        $ee = new Events();
        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };
        $fn4 = function () {
        };
        $fn5 = function () {
        };

        $ee->add_listeners([
            'foo' => [$fn1, $fn2, $fn3, $fn4, $fn5],
            'bar' => [$fn1, $fn2, $fn3, $fn4, $fn5],
            'baz' => [$fn1, $fn2, $fn3, $fn4, $fn5]
        ]);

        $ee->remove_listener('/ba[rz]/', $fn3);
        self::assertEquals([$fn5, $fn4, $fn3, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn5, $fn4, $fn3, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('foo'))));

        self::assertEquals([$fn5, $fn4, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertTrue(arrays_are_similar([$fn5, $fn4, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('bar'))));

        self::assertEquals([$fn5, $fn4, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('baz')));
        self::assertTrue(arrays_are_similar([$fn5, $fn4, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('baz'))));

    }

    // get_listeners_wrapper
    public function testReturnArrayForString()
    {
        $ee = new Events();
        $ee->add_listener('bar', function () {
        });
        $ee->add_listener('baz', function () {
        });

        $listeners = $ee->get_listeners_wrapper('bar');
        self::assertTrue(is_array($listeners));
        self::assertEquals(1, count($listeners['bar']));
    }

    public function testReturnArrayForRegex()
    {
        $ee = new Events();
        $ee->add_listener('bar', function () {
        });
        $ee->add_listener('baz', function () {
        });

        $listeners = $ee->get_listeners_wrapper('/ba[rz]/');
        self::assertTrue(is_array($listeners));
        self::assertEquals(1, count($listeners['bar']));
        self::assertEquals(1, count($listeners['baz']));

    }

    // define_event
    public function testDefinesEventWhenNothingElseInside()
    {
        $ee = new Events();
        $ee->define_event('foo');
        $listeners = $ee->get_listeners('foo');

        self::assertTrue(is_array($listeners));
        self::assertEquals(0, count($listeners));
    }

    public function testDefinesEventWhenOtherEventsAlready()
    {
        $ee = new Events();
        $f = function () {
        };

        $ee->add_listener('foo', $f);
        $ee->define_event('bar');

        self::assertEquals([$f], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(is_array($ee->get_listeners('bar')));
    }

    public function testNotOverwriteExistEvent()
    {
        $ee = new Events();
        $f = function () {
        };

        $ee->add_listener('foo', $f);
        $ee->define_event('foo');
        self::assertEquals([$f], $ee->flatten_listeners($ee->get_listeners('foo')));
    }

    // define events
    public function testDefinesMultipleEvents()
    {
        $ee = new Events();

        $ee->define_events(['foo', 'bar']);
        $foo_listeners = $ee->get_listeners('foo');
        $bar_listeners = $ee->get_listeners('bar');

        self::assertEquals(0, count($foo_listeners));
        self::assertEquals(0, count($bar_listeners));
    }

    // remove event
    public function testRemoveAllListenersForSpecificEvent()
    {
        $ee = new Events();
        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };
        $fn4 = function () {
        };
        $fn5 = function () {
        };

        $ee->add_listener('foo', $fn1);
        $ee->add_listener('foo', $fn2);
        $ee->add_listener('bar', $fn3);
        $ee->add_listener('bar', $fn4);
        $ee->add_listener('baz', $fn5);

        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo'))));

        self::assertEquals([$fn3, $fn4], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertTrue(arrays_are_similar([$fn3, $fn4], $ee->flatten_listeners($ee->get_listeners('bar'))));

        self::assertEquals([$fn5], $ee->flatten_listeners($ee->get_listeners('baz')));
        self::assertTrue(arrays_are_similar([$fn5], $ee->flatten_listeners($ee->get_listeners('baz'))));

        $ee->remove_event('bar');
        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo'))));

        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('bar')));

        self::assertEquals([$fn5], $ee->flatten_listeners($ee->get_listeners('baz')));
        self::assertTrue(arrays_are_similar([$fn5], $ee->flatten_listeners($ee->get_listeners('baz'))));

        $ee->remove_event('baz');
        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo'))));

        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('baz')));
    }

    public function testRemoveAllEventsWhenNoEventIsSpecified()
    {
        $ee = new Events();
        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };
        $fn4 = function () {
        };
        $fn5 = function () {
        };

        $ee->add_listener('foo', $fn1);
        $ee->add_listener('foo', $fn2);
        $ee->add_listener('bar', $fn3);
        $ee->add_listener('bar', $fn4);
        $ee->add_listener('baz', $fn5);

        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo'))));

        self::assertEquals([$fn3, $fn4], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertTrue(arrays_are_similar([$fn3, $fn4], $ee->flatten_listeners($ee->get_listeners('bar'))));

        self::assertEquals([$fn5], $ee->flatten_listeners($ee->get_listeners('baz')));
        self::assertTrue(arrays_are_similar([$fn5], $ee->flatten_listeners($ee->get_listeners('baz'))));

        $ee->remove_event();
        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('baz')));
    }

    public function testRemovesListenersWhenPassedARegex()
    {
        $ee = new Events();
        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };
        $fn4 = function () {
        };
        $fn5 = function () {
        };

        $ee->add_listener('foo', $fn1);
        $ee->add_listener('foo', $fn2);
        $ee->add_listener('bar', $fn3);
        $ee->add_listener('bar', $fn4);
        $ee->add_listener('baz', $fn5);

        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertEquals([$fn3, $fn4], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertEquals([$fn5], $ee->flatten_listeners($ee->get_listeners('baz')));

        $check = [];
        $ee->remove_event();

        $ee->add_listener('foo', function () use (&$check) {
            array_push($check, 1);
            return 'foo';
        });
        $ee->add_listener('bar', function () use (&$check) {
            array_push($check, 2);
            return 'bar';
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 3);
            return 'baz';
        });

        $ee->remove_event('/ba[rz]/');
        $listeners = $ee->get_listeners('foo');
        self::assertEquals(1, count($listeners));
        self::assertEquals('foo', $listeners[0]['listener']());
    }

    public function testCanBeUsedThroughAliasRemoveAllListeners()
    {
        $ee = new Events();
        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };
        $fn4 = function () {
        };
        $fn5 = function () {
        };

        $ee->add_listener('foo', $fn1);
        $ee->add_listener('foo', $fn2);
        $ee->add_listener('bar', $fn3);
        $ee->add_listener('bar', $fn4);
        $ee->add_listener('baz', $fn5);

        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo'))));

        self::assertEquals([$fn3, $fn4], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertTrue(arrays_are_similar([$fn3, $fn4], $ee->flatten_listeners($ee->get_listeners('bar'))));

        self::assertEquals([$fn5], $ee->flatten_listeners($ee->get_listeners('baz')));
        self::assertTrue(arrays_are_similar([$fn5], $ee->flatten_listeners($ee->get_listeners('baz'))));

        $ee->remove_all_listeners('bar');
        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo'))));

        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertEquals([$fn5], $ee->flatten_listeners($ee->get_listeners('baz')));
        self::assertTrue(arrays_are_similar([$fn5], $ee->flatten_listeners($ee->get_listeners('baz'))));

        $ee->remove_all_listeners('baz');
        self::assertEquals([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn1, $fn2], $ee->flatten_listeners($ee->get_listeners('foo'))));

        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('baz')));
    }

    // emit event
    public function testExecAttachedListeners()
    {
        $run = false;
        $ee = new Events();

        $ee->add_listener('foo', function () use (&$run) {
            $run = true;
        });
        $ee->emit_event('foo');
        self::assertTrue($run);
    }

    public function testExecAttachedWithASingleArgument()
    {
        $key = null;
        $ee = new Events();

        $ee->add_listener('bar', function ($a) use (&$key) {
            $key = $a;
        });
        $ee->emit_event('bar', [50]);

        self::assertEquals(50, $key);
        $ee->emit_event('bar', 60);
        self::assertEquals(60, $key);
    }

    public function testExecAttachedWithArguments()
    {
        $key = null;
        $ee = new Events();

        $ee->add_listener('bar2', function ($a, $b) use (&$key) {
            $key = $a + $b;
        });
        $ee->emit_event('bar2', [40, 2]);

        self::assertEquals(42, $key);
    }

    public function testExecMultipleListeners()
    {
        $check = [];
        $ee = new Events();

        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 2);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 3);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 4);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 5);
        });

        $ee->emit_event('baz');
        self::assertEquals('1,2,3,4,5', self::flattenCheck($check));
    }

    public function testExecMultipleListenersAfterOneHaveBeenRemoved()
    {
        $check = [];
        $toRemove = function () use (&$check) {
            array_push($check, 'R');
        };

        $ee = new Events();
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 2);
        });
        $ee->add_listener('baz', $toRemove);
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 3);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 4);
        });

        $ee->remove_listener('baz', $toRemove);
        $ee->emit_event('baz');

        self::assertEquals('1,2,3,4', self::flattenCheck($check));

    }

    public function testCanRemoveAnotherListenerFromWithinListener()
    {
        $check = [];
        $toRemove = function () use (&$check) {
            array_push($check, '1');
        };

        $ee = new Events();
        $ee->add_listener('baz', $toRemove);
        $ee->add_listener('baz', function () use (&$check, &$toRemove, &$ee) {
            array_push($check, 2);
            $ee->remove_listener('baz', $toRemove);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 3);
        });

        $ee->emit_event('baz');
        $ee->emit_event('baz');

        self::assertEquals('1,2,2,3,3', self::flattenCheck($check));
    }

    public function testExecMultipleListenersAndRemovesThoseThatReturnTrue()
    {
        $check = [];
        $ee = new Events();

        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 2);
            return true;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 3);
            return false;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 4);
            return 1;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 5);
            return true;
        });

        $ee->emit_event('baz');
        $ee->emit_event('baz');

        self::assertEquals('1,1,2,3,3,4,4,5', self::flattenCheck($check));
    }

    public function testCanRemoveListenersThatReturnTrueAndAlsoDefineAnotherListenerWithinThem()
    {
        $check = [];
        $ee = new Events();

        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('baz', function () use (&$check, &$ee) {
            $ee->add_listener('baz', function () use (&$check) {
                array_push($check, 2);
            });

            array_push($check, 3);
            return true;
        });

        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 4);
            return false;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 5);
            return 1;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 6);
            return true;
        });

        $ee->emit_event('baz');
        $ee->emit_event('baz');

        self::assertEquals('1,1,2,3,4,4,5,5,6', self::flattenCheck($check));
    }

    public function testExecAllListenersThatMatchARegularExpression()
    {
        $check = [];
        $ee = new Events();

        $ee->add_listener('foo', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('bar', function () use (&$check) {
            array_push($check, 2);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 3);
        });

        $ee->emit_event('/ba[rz]/');
        self::assertEquals('2,3', self::flattenCheck($check));
    }

    public function testGlobalObjectIsDefined()
    {
        $ee = new Events();
        $ee->add_listener('foo', function () use (&$ee) {
            $this->markTestSkipped(
                'this is not same as JavaScript'
            );
//            self::assertEquals($this, $ee);
        });

        $ee->emit_event('foo');
    }

    public function testListenersAreExecedInTheOrderTheyAreAdded()
    {
        $check = [];
        $ee = new Events();

        $ee->add_listener('foo', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('foo', function () use (&$check) {
            array_push($check, 2);
        });
        $ee->add_listener('foo', function () use (&$check) {
            array_push($check, 3);
        });
        $ee->add_listener('foo', function () use (&$check) {
            array_push($check, 4);
        });
        $ee->add_listener('foo', function () use (&$check) {
            array_push($check, 5);
        });
        $ee->emit_event('foo');
        self::assertEquals([1, 2, 3, 4, 5], $check);
    }

    // manipulate_listeners
    public function testManipulateMultipleWithArray()
    {
        $ee = new Events();
        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };
        $fn4 = function () {
        };
        $fn5 = function () {
        };

        $ee->manipulate_listeners(false, 'foo', [$fn1, $fn2, $fn3, $fn4, $fn5]);
        self::assertEquals([$fn5, $fn4, $fn3, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn5, $fn4, $fn3, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('foo'))));

        $ee->manipulate_listeners(true, 'foo', [$fn1, $fn2]);
        self::assertEquals([$fn5, $fn4, $fn3], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn5, $fn4, $fn3], $ee->flatten_listeners($ee->get_listeners('foo'))));

        $ee->manipulate_listeners(true, 'foo', [$fn3, $fn5]);
        $ee->manipulate_listeners(false, 'foo', [$fn4, $fn1]);
        self::assertEquals([$fn4, $fn1], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn4, $fn1], $ee->flatten_listeners($ee->get_listeners('foo'))));

        $ee->manipulate_listeners(true, 'foo', [$fn4, $fn1]);
        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('foo')));
    }

    public function testManipulateWithAnArray()
    {
        $ee = new Events();
        $fn1 = function () {
            echo "fn1\n";
        };
        $fn2 = function () {
            echo "fn2\n";
        };
        $fn3 = function () {
            echo "fn3\n";
        };
        $fn4 = function () {
            echo "fn4\n";
        };
        $fn5 = function () {
            echo "fn5\n";
        };

        $ee->manipulate_listeners(false, [
            'foo' => [$fn1, $fn2, $fn3],
            'bar' => $fn4
        ]);

        $ee->manipulate_listeners(false, [
            'bar' => [$fn5, $fn1]
        ]);

        self::assertEquals([$fn3, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn3, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('foo'))));

        self::assertEquals([$fn4, $fn1, $fn5], $ee->flatten_listeners($ee->get_listeners('bar')));
        self::assertTrue(arrays_are_similar([$fn4, $fn1, $fn5], $ee->flatten_listeners($ee->get_listeners('bar'))));

        $ee->manipulate_listeners(true, [
            'foo' => $fn1,
            'bar' => [$fn5, $fn4]
        ]);

        self::assertEquals([$fn3, $fn2], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertTrue(arrays_are_similar([$fn3, $fn2], $ee->flatten_listeners($ee->get_listeners('foo'))));

        $ee->manipulate_listeners(true, [
            'foo' => [$fn3, $fn2],
            'bar' => $fn1
        ]);

        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('foo')));
        self::assertEquals([], $ee->flatten_listeners($ee->get_listeners('bar')));
    }

    public function testNotExecListenersJustAfterTheyAreAddedInAnotherListeners()
    {
        $check = [];
        $ee = new Events();

        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 2);
        });
        $ee->add_listener('baz', function () use (&$check, &$ee) {
            array_push($check, 3);

            $ee->add_listener('baz', function () use (&$check) {
                array_push($check, 4);
            });
        });

        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 5);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 6);
        });

        $ee->emit_event('baz');

        self::assertEquals('1,2,3,5,6', self::flattenCheck($check));
    }

    // add_listeners
    public function testAddsWithAnArray()
    {
        $ee = new Events();
        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };
        $fn4 = function () {
        };
        $fn5 = function () {
        };

        $ee->add_listeners('foo', [$fn1, $fn2, $fn3]);
        self::assertTrue(arrays_are_similar([$fn3, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('foo'))));

        $ee->add_listeners('foo', [$fn4, $fn5]);
        self::assertTrue(arrays_are_similar([$fn3, $fn2, $fn1, $fn5, $fn4], $ee->flatten_listeners($ee->get_listeners('foo'))));
    }

    public function testAddsAnArray()
    {
        $ee = new Events();
        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };
        $fn4 = function () {
        };
        $fn5 = function () {
        };

        $ee->add_listeners([
            'foo' => $fn1,
            'bar' => [$fn2, $fn3]
        ]);
        self::assertTrue(arrays_are_similar([$fn1], $ee->flatten_listeners($ee->get_listeners('foo'))));
        self::assertTrue(arrays_are_similar([$fn3, $fn2], $ee->flatten_listeners($ee->get_listeners('bar'))));

        $ee->add_listeners([
            'foo' => [$fn4],
            'bar' => $fn5
        ]);
        self::assertTrue(arrays_are_similar([$fn1, $fn4], $ee->flatten_listeners($ee->get_listeners('foo'))));
        self::assertTrue(arrays_are_similar([$fn3, $fn2, $fn5], $ee->flatten_listeners($ee->get_listeners('bar'))));
    }

    public function testRemovesWithRegexInAddListeners()
    {
        $ee = new Events();
        $fn1 = function () {
        };
        $fn2 = function () {
        };
        $fn3 = function () {
        };
        $fn4 = function () {
        };
        $fn5 = function () {
        };

        $ee->add_listeners([
            'foo' => [$fn1, $fn2, $fn3, $fn4, $fn5],
            'bar' => [$fn1, $fn2, $fn3, $fn4, $fn5],
            'baz' => [$fn1, $fn2, $fn3, $fn4, $fn5]
        ]);
        $ee->remove_listeners('/ba[rz]/', [$fn3, $fn4]);

        self::assertTrue(arrays_are_similar([$fn5, $fn4, $fn3, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('foo'))));
        self::assertTrue(arrays_are_similar([$fn5, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('bar'))));
        self::assertTrue(arrays_are_similar([$fn5, $fn2, $fn1], $ee->flatten_listeners($ee->get_listeners('baz'))));
    }

    // set_once_return_value
    public function testWillRemoveIfLeftAsDefaultAndReturningTrue()
    {
        $check = [];
        $ee = new Events();

        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 2);
            return true;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 3);
            return false;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 4);
            return 1;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 5);
            return true;
        });

        $ee->emit_event('baz');
        $ee->emit_event('baz');

        self::assertEquals('1,1,2,3,3,4,4,5', self::flattenCheck($check));
    }

    public function testWillRemoveThoseThatReturnStringWhenSetToThatString()
    {
        $check = [];
        $ee = new Events();

        $ee->set_once_return_value('only-once');
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 2);
            return true;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 3);
            return 'only-once';
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 4);
            return 1;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 5);
            return 'only-once';
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 6);
            return true;
        });

        $ee->emit_event('baz');
        $ee->emit_event('baz');

        self::assertEquals('1,1,2,2,3,4,4,5,6,6', self::flattenCheck($check));
    }

    public function testWillNotRemoveThoseThatReturnADifferentStringToTheOneThatIsSet()
    {
        $check = [];
        $ee = new Events();

        $ee->set_once_return_value('only-once');
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 1);
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 2);
            return true;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 3);
            return 'not-only-once';
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 4);
            return 1;
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 5);
            return 'only-once';
        });
        $ee->add_listener('baz', function () use (&$check) {
            array_push($check, 6);
            return true;
        });

        $ee->emit_event('baz');
        $ee->emit_event('baz');

        self::assertEquals('1,1,2,2,3,3,4,4,5,6,6', self::flattenCheck($check));
    }

}
