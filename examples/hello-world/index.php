<?php
declare(strict_types=1);

require_once '../../index.php';

use Press\Press;

try {
    $app = new Press(__DIR__);
    $app->listen(function ($req, $res) use ($app) {
        echo "------------------- ??? \n";
        $output = $app->render('template.php');
        $res->end($output);
    });

} catch (Throwable $e) {
    var_dump($e);
}
