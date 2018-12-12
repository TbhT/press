<?php
declare(strict_types=1);

namespace Press;
use Swoole\Http\Request;
use Swoole\Http\Response;


/**
 * Class Press
 * @package Press
 */
class Press
{
    use Application;

    public function __construct()
    {
        $this->app_init();
        $this->verds_init();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (isset($this->$name)) {
            return call_user_func_array($this->$name, $arguments);
        } else {
            throw new \TypeError("{$name} is not supported");
        }
    }

    /**
     * @return \Closure
     */
    public function press()
    {
        return function (Request $req, Response $res, $next = null) {
            $req->app = $res->app = $this;
            $this->request = $req;
            $this->response = $res;

            $this->handle($req, $res, $next);
        };
    }

}