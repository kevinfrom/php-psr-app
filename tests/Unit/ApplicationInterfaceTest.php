<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use App\ApplicationInterface;
use PHPUnit\Framework\TestCase;

final class ApplicationInterfaceTest extends TestCase
{
    public function testApplicationCanRun(): void
    {
        $app = $this->createMock(ApplicationInterface::class);
        $app->expects($this->once())->method('run');

        $app->run();
    }
}
