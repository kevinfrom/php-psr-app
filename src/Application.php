<?php
declare(strict_types=1);

namespace App;

use App\Container\Container;

final class Application implements ApplicationInterface
{
    public function __construct(protected readonly Container $container)
    {
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        echo "Application is running!\n";
    }
}
