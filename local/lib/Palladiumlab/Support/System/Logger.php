<?php


namespace Palladiumlab\Support\System;


use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

class Logger extends MonologLogger
{
    /**
     * Функция возвращает объект Monolog\Logger,
     * с предустановленным обработчиком StreamHandler для записи в файл.
     *
     * @see https://github.com/Seldaek/monolog
     *
     * @param string $channel Название канала.
     * Нужно, чтобы отличать записи разных логгеров, пишущих в один файл.
     * Можно оставить пустым.
     *
     * @param string $file Полный путь к лог-файлу.
     * Если оставить пустым - путь будет браться из битрикс-константы LOG_FILENAME.
     * @param int $logLevel
     * @return Logger
     */
    public static function make(string $channel, string $file, int $logLevel = self::DEBUG): Logger
    {
        $logger = new Logger($channel);

        $logger->pushHandler(new StreamHandler($file, $logLevel));

        return $logger;
    }

    public static function makeDebug(): self
    {
        return self::make('debug', ROOT_PATH . '/logs/debug.log');
    }
}