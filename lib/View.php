<?php

namespace Press;


use Press\Helper\FunctionHelper;


class View
{
    public function __construct(string $name,array $options = [])
    {
        $this->default_engine = array_key_exists('defaultEngine', $options) ? $options['defaultEngine'] : null;
        $this->ext = FunctionHelper::extname($name);
        $this->name = $name;
        $this->root = array_key_exists('root', $options) ? $options['root'] : null;

        if (!$this->root || !$this->default_engine) {
            throw new \TypeError('root or defaultEngine must not be empty');
        }


    }

    public function loopup(string $name)
    {
        $roots = array_merge([], $this->root);

        foreach ($roots as $root) {
            $location = stream_resolve_include_path("{$root}/{$name}");
            $dir = dirname($location);
            $file = basename($location);

            $path = $this->resolve($dir, $file);
        }

        return $path;
    }

    public function render(array $options,callable $callback)
    {
        $this->engine($this->path, $options, $callback);
    }

    public function resolve(string $dir,string $file)
    {
        $path = join('.', [$dir, $file]);
        $stat =  self::try_stat($path);

        if (!empty($stat) && $stat['']) {
            //TODO: 
        }
    }

    private static function try_stat($path)
    {
        try {
            return stat($path);
        } catch (Throwable $e) {
            return null;
        }
    }
}