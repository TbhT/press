<?php
declare(strict_types=1);
/**
 * @see https://github.com/Olical/EventEmitter/blob/master/EventEmitter.js
 */

namespace Press\Utils;


class Events
{
    private $events = [];
    private $once_return_value = true;

    /**
     *  Finds the index of the listener for the event in its storage array.
     * @param $listeners
     * @param $listener
     * @return int
     */
    private function index_of_listener(array $listeners, $listener)
    {
        $length = count($listeners);

        while ($length--) {
            if (array_key_exists('listener', $listeners[$length]) && $listeners[$length]['listener'] === $listener) {
                return $length;
            }
        }

        return -1;
    }

    /**
     * @return array
     */
    private function & get_events()
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

    /**
     * @return bool
     */
    private function get_once_return_value()
    {
        return $this->once_return_value;
    }

    /**
     * Returns the listener array for the specified event.
     * Will initialise the event object and listener arrays if required.
     * Will return an object if you use a regex search. The object contains keys for each matched event.
     * So /ba[rz]/ might return an object containing bar and baz. But only if you have either defined them with
     * defineEvent or added some listeners to them.
     * Each property in the object response is an array of listener functions.
     * @param string $event
     * @return array|mixed
     */
    public function &get_listeners(string $event)
    {
        $events = &$this->get_events();
        preg_match('/\/.*\//', $event, $m);
        $response = [];

        if (count($m) > 0) {
            foreach ($events as $evt => $value) {
                preg_match($event, $evt, $matches);
                if (count($matches) > 0) {
                    $response[$evt] = &$events[$evt];
                }
            }
        } else if (array_key_exists($event, $events)) {
            $response = &$events[$event];
        } else {
            $events[$event] = [];
            $response = &$events[$event];
        }

        return $response;
    }

    /**
     * @param string $evt
     * @return array
     */
    public function get_listeners_wrapper(string $evt)
    {
        $listeners = $this->get_listeners($evt);
        $response = [];
        preg_match('/\/.*\//', $evt, $matches);

        if (count($matches) > 0) {
            $response = $listeners;
        } else {
            $response[$evt] = $listeners;
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
            array_push($flat_listeners, $listener['listener']);
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
    public function add_listener(string $evt, $listener)
    {
        if ($this->is_valid_listener($listener) === false) {
            throw new \TypeError('listener must be function');
        }

        $listeners = $this->get_listeners_wrapper($evt);
        $events = &$this->events;

        foreach ($listeners as $event => $value) {
            if ($this->index_of_listener($value, $listener) === -1) {
                if (is_array($listener) && array_key_exists('listener', $listener)) {
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
    public function remove_listener(string $evt, callable $listener)
    {
        $listeners = $this->get_listeners_wrapper($evt);
        $events = &$this->events;

        foreach ($listeners as $event => $lst) {
            $index = $this->index_of_listener($events[$event], $listener);

            if ($index !== -1) {
                array_splice($events[$event], $index, 1);
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

    /**
     * @param $evt
     * @param array $listeners
     * @return Events
     */
    public function add_listeners($evt, array $listeners = [])
    {
        return $this->manipulate_listeners(false, $evt, $listeners);
    }

    /**
     * @param $evt
     * @param array $listeners
     * @return Events
     */
    public function remove_listeners($evt, array $listeners = [])
    {
        return $this->manipulate_listeners(true, $evt, $listeners);
    }

    /**
     * @param bool $remove
     * @param $evt
     * @param array $listeners
     * @return Events
     */
    public function manipulate_listeners(bool $remove, $evt, array $listeners = [])
    {
        $single_fn = $remove ? 'remove_listener' : 'add_listener';
        $multiple_fn = $remove ? 'remove_listeners' : 'add_listeners';
        $evt_flag = is_array($evt);

        if ($evt_flag) {
            foreach ($evt as $event => $value) {
                if (is_callable($value)) {
                    call_user_func([$this, $single_fn], $event, $value);
                } else {
                    call_user_func([$this, $multiple_fn], $event, $value);
                }
            }
        } else {
            /**
             * so event must be string and listeners must be an array of listeners
             * loop over it and pass each one to the multiple method
             */
            $i = count($listeners);
            while ($i--) {
                call_user_func([$this, $single_fn], $evt, $listeners[$i]);
            }
        }

        return $this;
    }

    /**
     * @param string $evt
     * @return $this
     */
    public function remove_event(string $evt = '')
    {
        $events = &$this->get_events();
        preg_match('/\/\w+\//i', $evt, $m);

        // Remove different things depending on the state of evt
        if (is_string($evt) && empty($evt) === false) {
            // Remove all listeners for the specified event
            unset($events[$evt]);
        } else if (count($m) > 0) {
            // Remove all events matching the regex.
            foreach ($events as $event => $value) {
                preg_match($evt, $event, $m);
                if (count($m) > 0) {
                    unset($event[$evt]);
                }
            }
        } else {
            $events = [];
        }

        return $this;
    }

    /**
     * @param string $evt
     * @return Events
     */
    public function remove_all_listeners(string $evt)
    {
        return $this->remove_event($evt);
    }

    /**
     * @param string $evt
     * @param array $args
     * @return Events
     */
    public function emit_event(string $evt, $args = [])
    {
        $listeners_wrap = $this->get_listeners_wrapper($evt);

        foreach ($listeners_wrap as $event => $listeners) {
            foreach ($listeners as $index => $listener) {
                if ($listener['once'] === true) {
                    $this->remove_listener($evt, $listener['listener']);
                }

                if (is_array($args) === false) {
                    $args_ = func_get_args();
                    array_splice($args_, 0, 1);
                    $args = $args_;
                }

                $response = call_user_func_array($listener['listener'], $args);

                if ($response === $this->get_once_return_value()) {
                    $this->remove_listener($evt, $listener['listener']);
                }
            }
        }

        return $this;
    }

    /**
     * @param string $evt
     * @param array $args
     * @return Events
     */
    public function trigger(string $evt, array $args = [])
    {
        return $this->emit_event($evt, $args);
    }

    /**
     * @param string $evt
     * @return Events
     */
    public function emit(string $evt)
    {
        $args = array_slice(func_get_args(), 1);
        return $this->emit_event($evt, $args);
    }

    /**
     * @param $value
     * @return $this
     */
    public function set_once_return_value($value)
    {
        $this->once_return_value = $value;
        return $this;
    }


}
