<?php
declare(strict_types=1);

namespace App\Logging;

use Psr\Log\LoggerInterface;
use Stringable;

final class FileLogger implements LoggerInterface
{
    use LoggerTrait;

    public function __construct(public readonly string $filePath = LOGS_DIR . DS . 'app.log')
    {
    }

    /**
     * @inheritDoc
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        if ($context) {
            $message = $this->interpolate($message, $context);
        }

        $logMessage = sprintf("[%s] %s: %s\n", $this->getTimestamp(), mb_strtoupper($level), $message);

        if (!is_dir(dirname($this->filePath))) {
            mkdir(dirname($this->filePath), recursive: true);
        }

        file_put_contents($this->filePath, $logMessage, FILE_APPEND | LOCK_EX);
    }
}
