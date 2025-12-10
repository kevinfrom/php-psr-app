<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRules(rules: [
        '@PSR12' => true
    ])
    ->setFinder(
        finder: (new Finder())
            ->in([
                __DIR__ . '/app/',
                __DIR__ . '/core/',
            ])
    );
