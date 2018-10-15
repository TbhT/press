<?php
declare(strict_types=1);

require_once './vendor/autoload.php';

use Press\Press;

try {
    $app = new Press();
//$app->listen(function ($req, $res) {
//    echo '-------------------';
//});

    $output = $app->render('hello.php');

    echo $output;
} catch (Throwable $e) {
    var_dump($e);
}
