<?php

declare(strict_types=1);

namespace KevinFrom\PhpPsr\Core\Container;

use ArrayObject;
use Psr\Container\ContainerInterface;

final class Container implements ContainerInterface
{
    protected readonly ArrayObject $definitions;
    protected readonly ArrayObject $instances;

    public function __construct(
        public readonly bool $autowire,
        public readonly bool $cache
    ) {
        $this->definitions = new ArrayObject();
        $this->instances   = new ArrayObject();

        if ($this->cache) {
            // @TODO: If cache is enabled, load cache from disk

            register_shutdown_function(function () {
                // @TODO: Save cache to disk
            });
        }
    }

    public function get(string $id)
    {
        if ($this->instances->offsetExists($id)) {
            return $this->instances->offsetGet($id);
        }

        if ($this->definitions->offsetExists($id)) {
            return $this->definitions->offsetGet($id);
        }

        if (!$this->autowire) {
            throw new NotFoundException("Could not find service: $id");
        }

        // @TODO: Try to resolve the dependency
    }

    public function has(string $id): bool
    {
        if ($this->instances->offsetExists($id)) {
            return true;
        }

        if ($this->definitions->offsetExists($id)) {
            return true;
        }

        if (!$this->autowire) {
            return false;
        }

        // @TODO: Try to resolve the dependency
    }
}
