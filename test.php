<?php

require_once './index.php';

use Press\Press;


try {
  $app = new Press(__DIR__);
  $app->use(function ($req, $res, $next) {
    echo "我是中文啊!\n";
    $next();
  });

  $app->listen();
} catch (\Throwable $th) {
  var_dump($th);
}
