<?php
declare(strict_types=1);

namespace Tests\Unit\Logger;

use App\Logging\FileLogger;
use PHPUnit\Framework\TestCase;

final class FileLoggerTest extends TestCase
{
    public function testLog(): void
    {
        $filePath = TMP_DIR . DS . uniqid() . '-test.log';
        $testMessage = 'This is a test log message';

        $fileLogger = new FileLogger($filePath);

        $this->assertFileDoesNotExist($filePath);

        $fileLogger->debug($testMessage);

        $this->assertFileExists($filePath);
        $this->assertStringContainsString($testMessage, file_get_contents($filePath));

        unlink($filePath);
    }

    public function testLogWithContext(): void
    {
        $filePath = TMP_DIR . DS . uniqid() . '-test-context.log';
        $testMessage = 'This is a test log message with context. User: {user}, Action: {action}';

        $context = [
            'user' => 'test_user',
            'action' => 'test_action'
        ];

        $fileLogger = new FileLogger($filePath);

        $this->assertFileDoesNotExist($filePath);

        $fileLogger->debug($testMessage, $context);

        $this->assertFileExists($filePath);

        $fileContents = file_get_contents($filePath);

        $this->assertStringContainsString('This is a test log message with context.', $fileContents);
        $this->assertStringContainsString('User: test_user', $fileContents);
        $this->assertStringContainsString('Action: test_action', $fileContents);

        unlink($filePath);
    }
}
