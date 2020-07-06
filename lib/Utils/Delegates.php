<?php


namespace Press\Utils;


class Delegates
{
    private object $proto;

    private object $target;

    private array $methods = [];

    private array $getters = [];

    private array $setters = [];

    private array $fluents = [];

    public function __construct($proto, $target)
    {
        $this->proto = $proto;
        $this->target = $proto->$target;
    }

    public function method(string $name): Delegates
    {
        $that = $this;
        array_push($this->methods, $name);

        $this->proto->$name = function () use ($name, $that) {
            $args = func_get_args();
            return ($that->target->$name)(...$args);
        };

        return $this;
    }

    public function getter(string $name): Delegates
    {
        array_push($this->getters, $name);
        if (is_callable($this->target->$name)) {
            $this->proto->$name = ($this->target->$name)();
        } else {
            $this->proto->$name = $this->target->$name;
        }

        return $this;
    }

    public function setter(string $name): Delegates
    {
        return $this->getter($name);
    }

    public function access(string $name): Delegates
    {
        return $this->getter($name);
    }

    public function fluent($name): Delegates
    {
        array_push($this->fluents, $name);
        $that = $this;

        $this->proto->$name = function ($value = null) use ($name, $that) {
            if (gettype($value) !== 'NULL') {
                $that->target->$name = $value;
                return $that->target;
            } else {
                return $that->target->$name;
            }
        };

        return $this;
    }

}