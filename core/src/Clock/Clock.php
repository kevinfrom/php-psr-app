<?php

declare(strict_types=1);

namespace KevinFrom\PhpPsr\Core\Clock;

use DateTimeImmutable;
use Exception;
use Psr\Clock\ClockInterface;

final class Clock implements ClockInterface
{
    protected static ?DateTimeImmutable $testNow = null;

    /**
     * Set test now. Very useful for testing, when you want to mock a given time.
     *
     * @throws Exception
     */
    public static function setTestNow(DateTimeImmutable|string|null $testNow): void
    {
        if (is_string($testNow)) {
            $testNow = new DateTimeImmutable($testNow);
        }

        self::$testNow = $testNow;
    }

    /**
     * Get the current test now value.
     */
    public static function getTestNow(): ?DateTimeImmutable
    {
        return self::$testNow;
    }

    /**
     * Returns the current time as a DateTimeImmutable object. If a test now value is set, it will be returned instead.
     *
     * @return DateTimeImmutable
     */
    public function now(): DateTimeImmutable
    {
        return self::getTestNow() ?? new DateTimeImmutable();
    }
}
