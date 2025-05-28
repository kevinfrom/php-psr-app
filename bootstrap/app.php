<?php
declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . 'paths.php';

require VENDOR_DIR . DS . 'autoload.php';

use App\Application;

$app = new Application();
$app->run();
