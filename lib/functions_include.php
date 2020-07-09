<?php

if (!\function_exists('Press\Utils\Compose\compose')) {
    require __DIR__ . '/Utils/Compose.php';
}

if (!\function_exists('Press\Utils\Respond\respond')) {
    require __DIR__ . '/Respond.php';
}

if (!\function_exists('Press\Utils\Fresh\fresh')) {
    require __DIR__ . '/Utils/Fresh.php';
}

if (!\function_exists('Press\Utils\ContentType\format')
    || !\function_exists('Press\Utils\ContentType\parse')
) {
    require __DIR__ . '/Utils/ContentType.php';
}