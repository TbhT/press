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
     */
    private function index_of_listener($listeners, $liener)
    {
        $length = count($listeners);
        while ($length--) {
            if ($listeners[$length]->listener === $liener) {
                return $length;
            }
        }

        return -1;
    }

    private function get_events()
    {
        return $this->events;
    }

    private function is_valid_listener()
    {

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


    }

    public function flatten_listeners()
    {

    }

    public function add_listener()
    {

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
