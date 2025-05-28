<?php
declare(strict_types=1);

namespace App\Container;

use App\Container\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;
use Throwable;

final class Container implements ContainerInterface
{
    /** @var array<string, class-string|callable> */
    protected array $bindings = [];

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            try {
                $entry = $this->bindings[$id];

                if (is_callable($entry)) {
                    return $entry($this);
                }

                return new $entry();
            } catch (Throwable) {
                throw new ContainerException("Failed to create instance for '$id'");
            }
        }

        throw new ContainerException("Invalid binding for '$id'");
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }

    /**
     * @param class-string          $id
     * @param callable|class-string $concrete
     *
     * @return void
     */
    public function bind(string $id, callable|string $concrete): void
    {
        $this->bindings[$id] = $concrete;
    }
}
