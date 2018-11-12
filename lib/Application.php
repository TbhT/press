<?php
declare(strict_types=1);

namespace Press;

use Press\Helper\ArrayHelper;
use Press\Helper\HttpHelper;
use Press\Router;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Press\View;
use Press\Middleware;
use Press\Utils\Events;
use Press\Utils\Utils;


trait Application
{
    // implement multi extends
    use Events\EventTrait;

    private $router = null;
    private $cache = [];
    private $engines = [];
    private $settings = [];
    private $locals = [];
    private $mountpath = '/';

    public $views_path;
    public $request;
    public $response;

    public function  app_init($views_path = '')
    {
        $this->views_path = $views_path;
        $this->default_configuration();
    }

    private function default_configuration()
    {
        $env = defined('PRESS_DEBUG') ? PRESS_DEBUG : 'development';

        // default setting
        $this->enable('x-power-by');
        $this->set('etag', 'weak');
        $this->set('env', $env);
        $this->set('query parser', 'extended');
        $this->set('subdomain', 2);
        $this->set('trust proxy', false);

        $this->on('mount', function () {

        });

        // default locals
        $this->locals['settings'] = $this->settings;

        // default configuration
        $this->set('view');
        $this->set('views', $this->views_path);

        if ($env === 'production') {
            $this->enable('view cache');
        }


    }

    private function lazy_router()
    {
        if (!$this->router) {
            echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
            $this->router = new Router\Router([
                'caseSensitive' => $this->enabled('case sensitive routing'),
                'strict' => $this->enabled('strict routing')
            ]);

            $this->router->use(Middleware::query($this->get('query parser fn')));
            $this->router->use(Middleware::init($this));
        }
    }

    /**
     * @param Request $req
     * @param Response $res
     * @param callable $callback
     */
    public function handle(Request $req, Response $res, $callback = null)
    {
        //final handler todo: need to change
        if (!$callback) {
            $done = Middleware::final_handler($req, $res, [
                'env' => $this->get('env')
            ]);
        } else {
            $done = $callback;
        }

        var_dump($this->router);

        if (!$this->router) {
            $done();
            return;
        }

        $this->router->handle($req, $res, $done);
    }

    public function use($fn)
    {
        $offset = 0;
        $path = '/';

        $args = func_get_args();
        if (count($args) > 1) {
            $offset = 1;
            $path = $args[0];
        }

        $args = array_slice($args, $offset);
        $callbacks = ArrayHelper::flattenArray($args);

        if (count($callbacks) === 0) {
            throw new \TypeError('Router->use() requires a middleware function');
        }



    }

    public function route()
    {

    }

    public function param()
    {

    }

    /**
     * @param string $setting
     * @param $val
     * @return null|Application
     */
    public function set(string $setting, $val = '')
    {
        $args = func_get_args();
        if (count($args) === 1) {
            return array_key_exists($setting, $this->settings) ? $this->settings[$setting] : null;
        }

        // set value
        $this->settings[$setting] = $val;

        switch ($setting) {
            case 'etag':
                $this->set('etag fn', Utils::compile_etag($val));
                break;
            case 'query parser':
                $this->set('query parser fn', Utils::compile_query_parser($val));
                break;
            case 'trust proxy':
                $this->set('trust proxy fn', Utils::compile_trust($val));
                break;
        }

        return $this;
    }

    private function path()
    {
        return isset($this->parent) ? $this->parent->path() . $this->mountpath : '';
    }

    /**
     * @param string $setting
     * @return bool
     */
    public function enabled(string $setting)
    {
        return boolval($this->set($setting));
    }

    /**
     * @param string $setting
     * @return bool
     */
    public function disabled(string $setting)
    {
        return !$this->set($setting);
    }

    /**
     * @param string $setting
     * @return Application
     */
    public function enable(string $setting)
    {
        return $this->set($setting, true);
    }

    /**
     * @param string $setting
     * @return Application
     */
    public function disable(string $setting)
    {
        return $this->set($setting, false);
    }

    public function verds_init()
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

    /**
     * @param $path
     * @return $this
     */
    public function all($path)
    {
        $this->lazy_router();
        $route = $this->router->route($path);
        $args = array_slice(func_get_args(), 1);

        $methods = HttpHelper::methods();
        foreach ($methods as $method) {
            call_user_func_array([$route, $method], $args);
        }

        return $this;
    }

    public function render(string $name, array $options = [])
    {
        $view = new View($name, [
            'root' => $this->get('views')
        ]);

        return $view->render($name, $options);
    }

    /**
     * @return \swoole_http_server
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

        return $server;
    }


}