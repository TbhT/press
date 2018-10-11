<?php

declare(strict_types=1);


namespace Press\Router;

use Press\Helper\UrlHelper;
use Throwable;


/**
 * Class Layer
 * @property bool fast_slash
 * @property bool fast_star
 * @property null method
 * @package Press\Router
 */
class Layer
{
    private $handle;
    private $params;
    private $path;
    private $regexp;
    private $keys = [];
    private $options;


    /**
     * @param string $path
     * @param array $options
     * @param callable $fn
     */
    public function __construct($path, array $options = [], callable $fn)
    {
        $this->handle = $fn;
//        $this->name = null;   function name
        if (array_key_exists('end', $options) === false) {
            $options['end'] = false;
        }
        $this->regexp = UrlHelper::pathToRegExp($path, $this->keys, $options);

//        set fast path flags
        $this->fast_star = $path === '*';
        $this->fast_slash = $path === '/' && $options['end'] === false;
    }


    public function __call($name, $arguments)
    {
        if (isset($this->$name)) {
            call_user_func_array($this->$name, $arguments);
        }
    }


    /**
     * @param $error
     * @param $req
     * @param $res
     * @param $next
     */
    public function handle_error($error, $req, $res, callable $next)
    {
        try {
            ($this->handle)($error, $req, $res, $next);
        } catch (Throwable $error) {
            $next($error);
        }
    }


    /**
     * @param $req
     * @param $res
     * @param $next
     */
    public function handle_request($req, $res, callable $next)
    {
        try {
            ($this->handle)($req, $res, $next);
        } catch (Throwable $error) {
            $next($error);
        }
    }


    /**
     * @param $path
     * @return bool
     */
    public function match($path)
    {
        $match = null;

        if (empty($path) === false) {
            if ($this->fast_slash) {
                $this->params = [];
                $this->path = '';
                return true;
            }

            if ($this->fast_star) {
                $this->params = ['0' => self::decode_params($path)];
                $this->path = $path;
                return true;
            }

            $match = UrlHelper::match($this->regexp, $path);
        }

        if (empty($match)) {
            $this->params = null;
            $this->path = null;
            return false;
        }

        $this->params = [];
//        todo 需要看一下是否返回为数组
        $this->path = $match[0];
    }


    /**
     * @param $val
     * @return string
     */
    static private function decode_params($val)
    {
        return urldecode($val);
    }

}


