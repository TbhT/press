<?php

namespace Press;


class Middleware
{
    /**
     * @param Application $app
     * @return \Closure
     */
    public static function init(Application $app)
    {
        return function (Request $req, Response $res, callable $next) use ($app) {
            if ($app->enabled('x-power-by')) {
                $res->set('X-Power-By', 'Press');
            }

            $req->res = $res;
            $res->req = $req;
            $req->next = $next;

            $res->locals = empty($res->locals) ? [] : $res->locals;

            $next();
        };
    }

    public static function query()
    {
        return function () {

        };
    }

    /**
     * @param Request $req
     * @param Response $res
     * @param array $option
     * @return \Closure
     */
    public static function final_handler(Request $req, Response $res, array $option)
    {
        return function () use ($req, $res, $option) {

        };
    }
}