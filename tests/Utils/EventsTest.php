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
}
