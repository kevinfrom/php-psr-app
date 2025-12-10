<?php

declare(strict_types=1);

namespace KevinFrom\PhpPsr\Tests\Logger;

use KevinFrom\PhpPsr\Core\Logging\FileLogger;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class FileLoggerTest extends TestCase
{
    #[Test]
    public function path_is_normalized(): void
    {
        $fileLogger = new FileLogger(path: __DIR__ . DS . 'logs' . DS, file: 'test.log');

        $filePathHasMultipleSlashes = str_contains(haystack: $fileLogger->getFilePath(), needle: DS . DS);

        $this->assertFalse($filePathHasMultipleSlashes, 'File path should only contain a single slash after normalization.');
    }

    #[Test]
    public function file_logger_can_log(): void
    {
        $message    = 'test';
        $fileLogger = new FileLogger(path: __DIR__ . DS . 'logs', file: 'test.log');

        unlink(filename: $fileLogger->getFilePath());
        $this->assertFileDoesNotExist($fileLogger->getFilePath(), 'File should not exist before logging.');

        $fileLogger->info(message: $message);
        $this->assertFileExists($fileLogger->getFilePath(), 'File should exist after logging.');

        $logFileContents = file_get_contents(filename: $fileLogger->getFilePath());
        $this->assertStringContainsString($message, $logFileContents, 'Log file should contain test message after logging');
    }

    #[Test]
    public function interpolation_works(): void
    {
        $userId  = 1234;
        $message = 'User signed in: {userId}';
        $context = compact('userId');

        $fileLogger = new FileLogger(path: __DIR__ . DS . 'logs', file: 'test.log');

        unlink(filename: $fileLogger->getFilePath());
        $this->assertFileDoesNotExist($fileLogger->getFilePath(), 'File should not exist before logging.');

        $fileLogger->info(message: $message, context: $context);
        $this->assertFileExists($fileLogger->getFilePath(), 'File should exist after logging.');

        $logFileContents = file_get_contents(filename: $fileLogger->getFilePath());
        $this->assertStringContainsString("User signed in: $userId", $logFileContents, 'Log file should contain interpolated message after logging');
    }
}
