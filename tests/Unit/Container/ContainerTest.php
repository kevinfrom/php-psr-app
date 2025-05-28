<?php
declare(strict_types=1);

namespace App\Tests\Unit\Container;

use App\Container\Container;
use App\Tests\Utility\Container\TestObject;
use App\Tests\Utility\Container\TestObjectWithDependencies;
use PHPUnit\Framework\TestCase;

final class ContainerTest extends TestCase
{
    public function testHas(): void
    {
        $container = new Container();

        $this->assertFalse($container->has(TestObject::class));

        $container->bind(TestObject::class, TestObject::class);

        $this->assertTrue($container->has(TestObject::class));
    }

    public function testGet(): void
    {
        $container = new Container();

        $this->assertFalse($container->has(TestObject::class));

        $container->bind(TestObject::class, TestObject::class);
        $instance = $container->get(TestObject::class);

        $this->assertInstanceOf(TestObject::class, $instance);
    }

    public function testResolve(): void
    {
        $container = new Container();

        $this->assertFalse($container->has(TestObject::class));

        $instance = $container->get(TestObjectWithDependencies::class);
        $this->assertInstanceOf(TestObjectWithDependencies::class, $instance);
    }
}
