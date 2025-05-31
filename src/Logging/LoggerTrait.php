<?php
declare(strict_types=1);

namespace App\Logging;

use DateTime;
use InvalidArgumentException;
use Stringable;

trait LoggerTrait
{
    /**
     * Parse level to a string.
     *
     * @param $level
     *
     * @return string
     */
    public function parseLevel($level): string
    {
        if (is_string($level)) {
            return $level;
        }

        if ($level instanceof Stringable) {
            return $level->__toString();
        }

        throw new InvalidArgumentException("Invalid log level: " . gettype($level));
    }

    /**
     * Interpolates the message with the context values.
     *
     * @param Stringable|string $message
     * @param array $context
     * @return string
     */
    public function interpolate(Stringable|string $message, array $context = []): string
    {
        foreach ($context as $key => $value) {
            unset($context[$key]);

            $context['{' . $key . '}'] = $value;
        }

        return strtr($message, $context);
    }

    /**
     * Get timestamp for the log entry.
     *
     * @return string
     */
    public function getTimestamp(): string
    {
        return (new DateTime())->format('Y-m-d H:i:s');
    }

    /**
     * @inheritDoc
     */
    public function emergency(Stringable|string $message, array $context = []): void
    {
        $this->log('emergency', $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function alert(Stringable|string $message, array $context = []): void
    {
        $this->log('alert', $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function critical(Stringable|string $message, array $context = []): void
    {
        $this->log('critical', $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function error(Stringable|string $message, array $context = []): void
    {
        $this->log('error', $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function warning(Stringable|string $message, array $context = []): void
    {
        $this->log('warning', $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function notice(Stringable|string $message, array $context = []): void
    {
        $this->log('notice', $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function info(Stringable|string $message, array $context = []): void
    {
        $this->log('info', $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function debug(Stringable|string $message, array $context = []): void
    {
        $this->log('debug', $message, $context);
    }
}
