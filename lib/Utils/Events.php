<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-9-6
 * Time: 下午10:32
 * @see https://github.com/Olical/EventEmitter/blob/master/EventEmitter.js
 */

namespace Press\Utils;


use PHPUnit\Util\Type;

class Events
{
    private $events = [];

    /**
     *  Finds the index of the listener for the event in its storage array.
     */
    private function index_of_listener($listeners, $listener)
    {
        $length = count($listeners);
        while ($length--) {
            if ($listeners[$length]->listener === $listener) {
                return $length;
            }
        }

        return -1;
    }

    private function get_events()
    {
        return $this->events;
    }

    private function is_valid_listener($listener)
    {
        if (is_callable($listener)) {
            return true;
        } else if (is_array($listener)) {
            $flag = true;
            foreach ($listener as $item) {
                if (is_callable($item)) {
                    $flag = false;
                }
            }
            return $flag;
        } else {
            return false;
        }
    }

    private function get_once_return_value()
    {

    }

    /**
     * Returns the listener array for the specified event.
     * Will initialise the event object and listener arrays if required.
     * Will return an object if you use a regex search. The object contains keys for each matched event. So /ba[rz]/ might return an object containing bar and baz. But only if you have either defined them with defineEvent or added some listeners to them.
     * Each property in the object response is an array of listener functions.
     */
    public function get_listeners(string $event)
    {
        $events = $this->get_events();
        preg_match('/\/\w+\//i', $event, $m);
        $response = [];

        if (count($m) > 0) {
            foreach ($events as $evt) {
                preg_match($event, $evt, $matches);
                if (count($matches) > 0) {
                    $response[$evt] = $events[$evt];
                }
            }
        } else if (array_key_exists($event, $events)) {
            $response = $events[$event];
        }

        return $response;
    }

    /**
     * Takes a list of listener objects and flattens it into a list of listener functions.
     */
    public function flatten_listeners(array $listeners)
    {
        $flat_listeners = [];

        foreach ($listeners as $listener) {
            array_push($flat_listeners, $listener);
        }

        return $flat_listeners;
    }


    /**
     * Adds a listener function to the specified event.
     * The listener will not be added if it is a duplicate.
     * If the listener returns true then it will be removed after it is called.
     * If you pass a regular expression as the event name then the listener will be added
     * to all events that match it.
     */
    public function add_listener($evt, $listener)
    {
        if ($this->is_valid_listener($listener) === false) {
            throw new \TypeError('listener must be function');
        }

        $listeners = $this->get_listeners($evt);
    }

    public function on()
    {
        return $this->add_listener();
    }

    public function add_once_listener()
    {

    }

    public function once()
    {
        return $this->add_once_listener();
    }

    public function define_event()
    {

    }

    public function define_events()
    {

    }

    public function remove_listener()
    {

    }

    public function off()
    {
        return $this->remove_listener();
    }

    public function add_listeners()
    {

    }

    public function manipulate_listeners()
    {

    }

    public function remove_event()
    {

    }

    public function remove_all_listeners()
    {

    }

    public function emit_event()
    {

    }

    public function trigger()
    {

    }

    public function emit()
    {

    }

    public function set_once_return_value()
    {

    }


}
