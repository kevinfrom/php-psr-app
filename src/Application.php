<?php
declare(strict_types=1);

namespace App;

final class Application implements ApplicationInterface
{
    /**
     * @inheritDoc
     */
    public function run(): void
    {
        echo "Application is running!\n";
    }
}
