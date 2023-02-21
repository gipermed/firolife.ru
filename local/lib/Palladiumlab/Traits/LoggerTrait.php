<?php


namespace Palladiumlab\Traits;


use Monolog\Handler\HandlerInterface;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryUsageProcessor;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait as PsrLoggerTrait;
use ReflectionClass;

trait LoggerTrait
{
    use PsrLoggerTrait;

    protected $logger;

    public function log($level, $message, array $context = array())
    {
        if ($this->logger instanceof LoggerInterface) {
            $this->logger->log($level, $message, $context);
        }
    }

    public function setLogger(?LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function makeLogger(array $additionalHandlers = [])
    {
        $handlers = [];

        foreach ($additionalHandlers as $additionalHandler) {
            if ($additionalHandler instanceof HandlerInterface) {
                $handlers[] = $additionalHandler;
            }
        }

        return new Logger(
            $this->getLoggerShortName(),
            $handlers,
            [new MemoryUsageProcessor()]
        );
    }

    public function getLoggerShortName()
    {
        return (new ReflectionClass($this))->getShortName();
    }

    protected function getStreamHandler($stream = 'php://stdout')
    {
        return new StreamHandler($stream, Logger::DEBUG);
    }

    protected function getRotatingFileHandler(string $path, int $maxFiles = 10)
    {
        return new RotatingFileHandler($path, $maxFiles);
    }
}
