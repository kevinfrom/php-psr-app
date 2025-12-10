<?php

declare(strict_types=1);

namespace KevinFrom\PhpPsr\Tests\Container;

use KevinFrom\PhpPsr\Core\Container\Container;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use stdClass;

final class ContainerTest extends TestCase
{
    #[Test]
    public function can_add_definition(): void
    {
        $container = new Container(autowire: false, cache: false);

        $container->register('test', stdClass::class);
        $this->assertTrue($container->has('test'));
    }
}
