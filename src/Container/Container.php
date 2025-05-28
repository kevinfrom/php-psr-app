<?php
declare(strict_types=1);

namespace App\Container;

use App\Container\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;
use Throwable;

final class Container implements ContainerInterface
{
    /** @var array<string, class-string|callable> */
    protected array $bindings = [];

    /**
     * @template TClass of object
     * @param class-string<TClass> $id
     *
     * @return TClass
     * @phpstan-return TClass
     * @throws ContainerException
     */
    public function get(string $id)
    {
        try {
            if ($this->has($id)) {
                $entry = $this->bindings[$id];

                if (is_callable($entry)) {
                    return $entry($this);
                }

                /** @var class-string<TClass> $entry */
                return new $entry();
            }

            return $this->resolve($id);
        } catch (Throwable) {
            throw new ContainerException("Unable to resolve entry for ID: {$id}");
        }
    }

    /**
     * Check if the container has a binding for the given ID.
     *
     * @param class-string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }

    /**
     * @template TClass of object
     * @param class-string<TClass>  $id
     * @param callable|class-string $concrete
     *
     * @return void
     */
    public function bind(string $id, callable|string $concrete): void
    {
        $this->bindings[$id] = $concrete;
    }

    /**
     * Auto-resolve an entry by its ID.
     *
     * @template TClass of object
     * @param class-string<TClass> $id
     *
     * @return TClass
     * @phpstan-return TClass
     * @throws ReflectionException
     * @throws ContainerException
     */
    protected function resolve(string $id)
    {
        $reflectionClass = new ReflectionClass($id);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("Class {$id} is not instantiable.");
        }

        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $id();
        }

        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return new $id();
        }

        $dependencies = array_map(function (ReflectionParameter $parameter) {
            if (!$parameter->getType()) {
                throw new ContainerException("Parameter {$parameter->getName()} has no type hint.");
            }

            $type = $parameter->getType();

            if ($type instanceof ReflectionUnionType) {
                throw new ContainerException("Parameter {$parameter->getName()} has union type");
            }

            if ($type instanceof ReflectionIntersectionType) {
                throw new ContainerException("Parameter {$parameter->getName()} has intersection type");
            }

            if (!$type instanceof ReflectionNamedType) {
                throw new ContainerException("Parameter {$parameter->getName()} has an unsupported type");
            }

            if ($type->isBuiltin()) {
                throw new ContainerException("Parameter {$parameter->getName()} has a built-in type");
            }

            /** @var class-string $id */
            $id = $type->getName();

            return $this->get($id);
        }, $parameters);

        return new $id(...$dependencies);
    }
}
