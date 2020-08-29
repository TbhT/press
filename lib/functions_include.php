<?php

if (!function_exists('Press\Utils\Compose\compose')) {
    require __DIR__ . '/Utils/Compose.php';
}

if (!function_exists('Press\Utils\Respond\respond')) {
    require __DIR__ . '/Respond.php';
}

if (!function_exists('Press\Utils\Fresh\fresh')) {
    require __DIR__ . '/Utils/Fresh.php';
}

if (!function_exists('Press\Utils\ContentType\format')
    || !function_exists('Press\Utils\ContentType\parse')
) {
    require __DIR__ . '/Utils/ContentType.php';
}

if (!function_exists('Press\Utils\typeOfRequest')
    || !function_exists('Press\Utils\hasBody')
) {
    require __DIR__ . '/Utils/TypeIs.php';
}

if (!function_exists('Press\Utils\vary')) {
    require __DIR__ . '/Utils/Vary.php';
}

if (!function_exists('Press\Utils\Co\co')
    || !function_exists('Press\Utils\Co\convert')
    || !function_exists('Press\Utils\Co\isGeneratorFunction')) {
    require __DIR__ . '/Utils/Co.php';
}