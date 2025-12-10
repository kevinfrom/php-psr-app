<?php

declare(strict_types=1);

namespace KevinFrom\PhpPsr\Core\Logging;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Stringable;

/**
 * Implements generic functions for a Logger. It is expected that the implementing class implements the `log` method.
 */
trait LoggerTrait
{
    /**
     * Interpolates context values into the message placeholders.
     *
     * @param string|Stringable                $message
     * @param array<string, string|Stringable> $context
     *
     * @return string
     */
    protected function interpolate(string|Stringable $message, array $context = []): string
    {
        foreach ($context as $key => $value) {
            $message = str_replace(search: "{{$key}}", replace: (string)$value, subject: $message);
        }

        return $message;
    }

    /**
     * @see LoggerInterface::emergency()
     */
    public function emergency(string|Stringable $message, array $context = []): void
    {
        $this->log(level: LogLevel::EMERGENCY, message: $message, context: $context);
    }

    /**
     * @see LoggerInterface::alert()
     */
    public function alert(string|Stringable $message, array $context = []): void
    {
        $this->log(level: LogLevel::ALERT, message: $message, context: $context);
    }

    /**
     * @see LoggerInterface::critical()
     */
    public function critical(string|Stringable $message, array $context = []): void
    {
        $this->log(level: LogLevel::CRITICAL, message: $message, context: $context);
    }

    /**
     * @see LoggerInterface::error()
     */
    public function error(string|Stringable $message, array $context = []): void
    {
        $this->log(level: LogLevel::ERROR, message: $message, context: $context);
    }

    /**
     * @see LoggerInterface::warning()
     */
    public function warning(string|Stringable $message, array $context = []): void
    {
        $this->log(level: LogLevel::WARNING, message: $message, context: $context);
    }

    /**
     * @see LoggerInterface::notice()
     */
    public function notice(string|Stringable $message, array $context = []): void
    {
        $this->log(level: LogLevel::NOTICE, message: $message, context: $context);
    }

    /**
     * @see LoggerInterface::info()
     */
    public function info(string|Stringable $message, array $context = []): void
    {
        $this->log(level: LogLevel::INFO, message: $message, context: $context);
    }

    /**
     * @see LoggerInterface::debug()
     */
    public function debug(string|Stringable $message, array $context = []): void
    {
        $this->log(level: LogLevel::DEBUG, message: $message, context: $context);
    }

    /**
     * Format a message according to the given log level.
     *
     * @param string $level
     * @param string|Stringable $message
     * @param array<string, string|Stringable> $context
     *
     * @return string
     */
    public function format(string $level, string|Stringable $message, array $context = []): string
    {
        return vsprintf(format: "%s [%s] %s\n", values: [
            date('Y-m-d H:i:s'),
            $level,
            $this->interpolate($message, $context),
        ]);
    }
}
