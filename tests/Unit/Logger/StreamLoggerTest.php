<?php
declare(strict_types=1);

namespace Tests\Unit\Logger;

use App\Logging\StreamLogger;
use PHPUnit\Framework\TestCase;

final class StreamLoggerTest extends TestCase
{
    public function testLog(): void
    {
        $testMessage = 'This is a test log message';

        $stream = fopen('php://temp', 'w+');
        $this->assertIsResource($stream);

        $stdoutLogger = new StreamLogger($stream);
        $stdoutLogger->debug($testMessage);

        rewind($stream);
        $output = stream_get_contents($stream);

        $this->assertIsString($output);
        $this->assertStringContainsString($testMessage, $output);
    }

    public function testLogWithContext(): void
    {
        $testMessage = 'This is a test log message with context. User: {user}, Action: {action}';

        $context = [
            'user' => 'test_user',
            'action' => 'test_action'
        ];

        $stream = fopen('php://temp', 'w+');
        $this->assertIsResource($stream);

        $stdoutLogger = new StreamLogger($stream);
        $stdoutLogger->debug($testMessage, $context);

        rewind($stream);
        $output = stream_get_contents($stream);

        $this->assertIsString($output);
        $this->assertStringContainsString('This is a test log message with context.', $output);
        $this->assertStringContainsString('User: test_user', $output);
        $this->assertStringContainsString('Action: test_action', $output);
    }
}
