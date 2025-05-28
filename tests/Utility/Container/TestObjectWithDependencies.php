<?php
declare(strict_types=1);

namespace App\Tests\Utility\Container;

final class TestObjectWithDependencies
{
    public function __construct(protected readonly TestObject $testObject)
    {
    }
}
