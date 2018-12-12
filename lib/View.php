<?php

namespace Press;


use Press\Helper\FunctionHelper;


class View
{
    private $ext;
    private $name;
    private $root;
    private $path;

    /**
     * View constructor.
     * @param string $name
     * @param array $options
     */
    public function __construct(string $name, array $options = [])
    {
        $this->ext = FunctionHelper::extname($name);
        $this->name = $name;
        $this->root = array_key_exists('root', $options) ? $options['root'] : null;

        $file_name = $name;
        if (!$this->ext) {
            $file_name = "{$name}.php";
        }

        $this->path = $this->lookup($file_name);
    }

    /**
     * @param string $name
     * @return string
     */
    private function lookup(string $name)
    {
        $roots = [$this->root];
        $path = '';

        foreach ($roots as $root) {
            $location = stream_resolve_include_path("{$root}/{$name}");
            $dir = dirname($location);
            $file = basename($location);

            $path = $this->resolve($dir, $file);
        }
        var_dump($path);
        return $path;
    }

    /**
     * @param array $options
     * @return false|string
     * @throws \Throwable
     */
    public function render(array $options = [])
    {
        $ob_init_level = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        extract($options, EXTR_OVERWRITE);
        try {
            require $this->path;
            return ob_get_clean();
        } catch (\Exception $e) {
            while (ob_get_level() > $ob_init_level) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $ob_init_level) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }

    /**
     * @param string $dir
     * @param string $file
     * @return string
     */
    private function resolve(string $dir, string $file)
    {
        $path = join('.', [$dir, $file]);
        $ext = $this->ext;

        if (is_file($path)) {
            return $path;
        }

        $path = join([$dir, basename($file, $ext), "index{$ext}"]);
        if (is_file($path)) {
            return $path;
        }
    }
}