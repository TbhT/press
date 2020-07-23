<?php

$loader = @include __DIR__ . '/../vendor/autoload.php';

$loader->addPsr4('Press\\Tests\\', __DIR__);

if (!function_exists('Press\Tests\Context\create')
    || !function_exists('Press\Tests\Context\createWithReqOpt')
    || !function_exists('Press\Tests\Context\createWithResOpt')
) {
    require __DIR__ . '/Context.php';
}