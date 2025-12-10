<?php

declare(strict_types=1);

namespace KevinFrom\PhpPsr\Core\Logging;

use Psr\Log\LoggerInterface;
use Stringable;

final class FileLogger implements LoggerInterface
{
    use LoggerTrait;

    public function __construct(
        public readonly string $path = LOGS,
        public readonly string $file = 'app.log'
    ) {
    }

    /**
     * Get the full path to the log file.
     *
     * @return string
     */
    public function getFilePath(): string
    {
        $path = $this->path;

        if (str_ends_with(haystack: $path, needle: DS)) {
            $path = substr(string: $path, offset: 0, length: -1);
        }

        return $path . DS . $this->file;
    }

    /**
     * Logs with an arbitrary level. Appends to the log file. If the log file does not exist, it will be created.
     *
     * @see LoggerInterface::log()
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        file_put_contents(
            filename: $this->getFilePath(),
            data: $this->format($level, $message, $context),
            flags: FILE_APPEND,
        );
    }
}
