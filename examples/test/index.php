<?php

declare(strict_types=1);

use Press\Press;

try {
  $app = new Press(__DIR__);
  
} catch (\Throwable $th) {
  //throw $th;
}