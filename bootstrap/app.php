<?php
declare(strict_types=1);

require VENDOR_DIR . DS . 'autoload.php';

use App\Application;
use App\Container\Container;

$container = new Container();

$app = new Application($container);
$app->run();
