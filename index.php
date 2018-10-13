<?php
declare(strict_types=1);

require_once './vendor/autoload.php';

use Press\Press;

$app = new Press();
$app->listen(function ($req, $res) {
    echo '-------------------';
});