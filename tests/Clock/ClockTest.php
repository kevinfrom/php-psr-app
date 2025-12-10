<?php

declare(strict_types=1);

namespace KevinFrom\PhpPsr\Tests\Clock;

use DateTimeImmutable;
use KevinFrom\PhpPsr\Core\Clock\Clock;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ClockTest extends TestCase
{
    #[Test]
    public function now_equals_test_now(): void
    {
        $testNow = new DateTimeImmutable('2025-12-10 12:00:00');

        $this->assertNull(Clock::getTestNow(), 'Test now should be null before setting it.');

        Clock::setTestNow($testNow);

        $this->assertSame($testNow, Clock::getTestNow(), 'Test now should be set after setting it.');
        $this->assertSame($testNow, (new Clock())->now(), 'Clock::now() should return the test now.');
    }
}
