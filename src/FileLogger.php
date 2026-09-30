<?php

declare(strict_types=1);

namespace App;

use Psr\Log\AbstractLogger;

final class FileLogger extends AbstractLogger
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function log($level, $message, array $context = []): void
    {
        $line = sprintf(
            "[%s] %s: %s%s",
            date('Y-m-d H:i:s'),
            strtoupper((string) $level),
            (string) $message,
            PHP_EOL
        );

        file_put_contents($this->path, $line, FILE_APPEND);
    }
}
