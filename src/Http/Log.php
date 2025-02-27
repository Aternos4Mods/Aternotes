<?php

namespace App\Http;

class Log
{
    public static function write(string $level, mixed $message): void
    {
        $loggingFile = __DIR__ . '/../../storage/framework/aternotes.log';
        file_exists($loggingFile) || touch($loggingFile);

        file_put_contents($loggingFile, sprintf("[%s] %s: %s\n", date('d-m-Y H:i:s'), $level, $message), FILE_APPEND);
    }

    public static function debug(mixed $output): void
    {
        self::write('DEBUG', $output);
    }

    public static function info(mixed $output): void
    {
        self::write('INFO', $output);
    }

    public static function warning(mixed $output): void
    {
        self::write('WARNING', $output);
    }

    public static function error(mixed $output): void
    {
        self::write('ERROR', $output);
    }

    public static function critical(mixed $output): void
    {
        self::write('CRITICAL', $output);
    }
}