<?php

require_once '../../vendor/autoload.php';
require_once '../../lib/Press.php';

use Press\Press;

$app = new Press();

$app->get('/', function ($req, $res) {
    $res->send('Hello World');
});

$app->listen($app->press());

