<?php


namespace Palladiumlab\Console\Schedule;


use Closure;
use Crunz\Schedule as CrunzSchedule;

/**
 * Класс-обёртка для библиотеки Crunz\Schedule
 * добавляет дополнительную функциональность
 *
 * Class Schedule
 * @package Palladiumlab\Console\Schedule
 */
class Schedule extends CrunzSchedule
{
    public function command(string $command)
    {
        $phpBinPath = PHP_BINARY;
        $consolePath = dirname(__DIR__, 4) . '/console';

        return $this->run("{$phpBinPath} {$consolePath} {$command}");
    }

    /**
     * Add a new event to the schedule object.
     *
     * @param string|Closure $command
     * @param array $parameters
     *
     * @return Event
     */
    public function run($command, array $parameters = [])
    {
        if (is_string($command) && count($parameters)) {
            $command .= ' ' . $this->compileParameters($parameters);
        }

        $this->events[] = $event = new Event($this->id(), $command);

        return $event;
    }
}
