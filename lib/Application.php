<?php
declare(strict_types=1);

namespace Press;

use Press\Helper\HttpHelper;
use Press\Response;
use Press\Request;
use Press\Utils\Events;


trait Application
{
    // implement multi extends
    use Events\EventTrait;

    private $router;
    public $request;
    public $response;

    private function init()
    {

    }

    private function default_configuration()
    {

    }

    private function lazy_router()
    {

    }

    private function handle()
    {

    }

    public function use()
    {

    }

    public function route()
    {

    }

    public function engine()
    {

    }

    public function param()
    {

    }

    public function set()
    {

    }

    private function path()
    {

    }

    public function enabled()
    {

    }

    public function disabled()
    {

    }

    public function enable()
    {

    }

    public function disable()
    {

    }

    public function VERDSInit()
    {
        $methods = HttpHelper::methods();

        array_map(function ($method) {
            $this->$method = function ($path) use ($method) {
                $handles = func_get_args();

                if ($method === 'get' && count($handles) === 1) {
                    return $this->set($path);
                }

                $this->lazy_router();
                $route = $this->router->route($path);
                call_user_func_array([$route, $method], array_slice($handles, 1));

                return $this;
            };
        }, $methods);
    }

    public function all()
    {

    }

    public function render()
    {

    }

    /**
     * @return Application
     */
    public function listen()
    {
        $args = func_get_args();
        $host = array_key_exists('host', $args) ? $args[0] : '0.0.0.0';
        $port = array_key_exists('port', $args) ? $args[1] : 8080;

        if (is_callable($args[0])) {
            $callback = $args[0];
        } else {
            $callback = array_key_exists('callback', $args) ? $args['callback'] : $args[2];
        }
        $server = new \swoole_http_server($host, $port, SWOOLE_BASE);
        $server->on('request', $callback);
        $server->start();

        return $this;
    }


}