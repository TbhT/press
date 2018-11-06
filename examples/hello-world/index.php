<?php

require_once '../../vendor/autoload.php';
require_once '../../lib/Press.php';

use Press\Press;

$app = new Press();

$app->listen($app->press());

$app->get('/', function ($req, $res) {
    $res->send('Hello World');
});
