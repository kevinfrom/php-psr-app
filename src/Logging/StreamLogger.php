<?php
declare(strict_types=1);

namespace App\Logging;

use Psr\Log\LoggerInterface;
use RuntimeException;
use Stringable;

final class StreamLogger implements LoggerInterface
{
    use LoggerTrait;

    /** @var resource $stream */
    protected $stream;

    /**
     * @param string|resource $stream
     */
    public function __construct($stream = 'php://stdout')
    {
        if (is_string($stream)) {
            $stream = fopen($stream, 'w');
        }

        if (!is_resource($stream)) {
            throw new RuntimeException("Unable to open stream: $stream");
        }

        $this->stream = $stream;
    }

    /**
     * @inheritDoc
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        $level = $this->parseLevel($level);

        if ($context) {
            $message = $this->interpolate($message, $context);
        }

        $logMessage = sprintf("[%s] %s: %s\n", $this->getTimestamp(), mb_strtoupper($level), $message);

        fwrite($this->stream, $logMessage);
    }
}
