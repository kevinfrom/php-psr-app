<?php

declare(strict_types=1);

namespace KevinFrom\PhpPsr\Core;

final class Kernel
{
    /**
     * Bootstrap the application.
     */
    public function bootstrap(): void
    {
        $paths = [
            'paths.php',
        ];

        foreach ($paths as $path) {
            require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR . $path;
        }
    }
}
