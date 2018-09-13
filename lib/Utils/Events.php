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


class Events
{
    private $events = [];

    /**
     *  Finds the index of the listener for the event in its storage array.
     * @param $listeners
     * @param $listener
     * @return int
     */
    private function index_of_listener(array $listeners, callable $listener)
    {
        $length = count($listeners);
        while ($length--) {
            if ($listeners[$length]['listener'] === $listener) {
                return $length;
            }
        }

        return -1;
    }

    /**
     * @return array
     */
    private function get_events()
    {
        return $this->events;
    }

    /**
     * @param $listener
     * @return bool
     */
    private function is_valid_listener($listener)
    {
        if (is_callable($listener)) {
            return true;
        } else if (is_array($listener) && array_key_exists('listener', $listener)) {
            return $this->is_valid_listener($listener['listener']);
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
     * @param string $event
     * @return array|mixed
     */
    public function get_listeners(string $event)
    {
        $events = $this->get_events();
        preg_match('/\/\w+\//i', $event, $m);
        $response = [];

        if (count($m) > 0) {
            foreach ($events as $evt => $value) {
                preg_match($event, $evt, $matches);
                if (count($matches) > 0) {
                    $response[$evt] = $value;
                }
            }
        } else if (array_key_exists($event, $events)) {
            $response[$event] = $events[$event];
        } else {
            $events[$event] = [];

            // update events
            $this->events = $events;
            $response[$event] = [];
        }

        return $response;
    }

    /**
     * Takes a list of listener objects and flattens it into a list of listener functions.
     * @param array $listeners
     * @return array
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
     * @param $evt
     * @param $listener
     * @return Events
     */
    public function add_listener(string $evt, callable $listener)
    {
        if ($this->is_valid_listener($listener) === false) {
            throw new \TypeError('listener must be function');
        }

        $listeners = $this->get_listeners($evt);
        $events = &$this->events;

        foreach ($listeners as $event => $value) {
            if ($this->index_of_listener($value, $listener) === -1) {
                if (is_array($listener)) {
                    $listener = array_key_exists('listener', $listener) ?
                        $listener : ['listener' => $listener, 'once' => false];

                    array_push($events[$event], $listener);
                } else {
                    array_push($events[$event], ['listener' => $listener, 'once' => false]);
                }
            }
        }

        return $this;
    }

    /**
     * @param string $evt
     * @param callable $listener
     * @return Events
     */
    public function on(string $evt, callable $listener)
    {
        return $this->add_listener($evt, $listener);
    }

    /**
     * @param $evt
     * @param $listener
     * @return Events
     */
    public function add_once_listener(string $evt, callable $listener)
    {
        return $this->add_listener($evt, [
            'listener' => $listener,
            'once' => true
        ]);
    }

    /**
     * @param $evt
     * @param $listener
     * @return Events
     */
    public function once(string $evt, callable $listener)
    {
        return $this->add_once_listener($evt, $listener);
    }

    /**
     * @param string $event
     * @return Events
     */
    public function define_event(string $event)
    {
        $this->get_listeners($event);
        return $this;
    }

    /**
     * @param $evts
     * @return Events
     */
    public function define_events(array $evts)
    {
        foreach ($evts as $evt) {
            $this->define_event($evt);
        }

        return $this;
    }

    /**
     * @param $evt
     * @param $listener
     * @return Events
     */
    public function remove_listener(string $evt,callable $listener)
    {
        $listeners = $this->get_listeners($evt);

        foreach ($listeners as $l) {
            $index = $this->index_of_listener($l, $listener);

            if ($index !== -1) {
                array_splice($l, $index, 1);
            }
        }

        return $this;
    }

    /**
     * @param string $evt
     * @param callable $listener
     * @return Events
     */
    public function off(string $evt, callable $listener)
    {
        return $this->remove_listener($evt, $listener);
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
