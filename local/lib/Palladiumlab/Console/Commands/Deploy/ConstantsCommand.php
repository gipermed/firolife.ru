<?php


namespace Palladiumlab\Console\Commands\Deploy;


use Palladiumlab\Deploy\Constants\Dumper;
use Palladiumlab\Deploy\Constants\DumpProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConstantsCommand
 * @package Palladiumlab\Console\Commands\Deploy
 */
class ConstantsCommand extends Command
{
    protected const FILE_PATH = ROOT_PATH . '/local/php_interface/const.php';

    protected static $defaultName = 'deploy:constants';

    protected function configure()
    {
        $this->setDescription('Дамп констант в файл');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (new DumpProcessor($this->getDumpers()))
            ->process()
            ->putContent(self::FILE_PATH);

        $output->writeln(PHP_EOL . '    <info>Константы сгенерированы!</info>' . PHP_EOL);

        return 0;
    }

    protected function getDumpers(): array
    {
        return [
            new Dumper\IblockDumper(),
			new Dumper\PropertyDumper(),
            new Dumper\DeliveryServiceDumper(),
            new Dumper\HighloadBlockDumper(),
            new Dumper\PaySystemDumper(),
            new Dumper\PersonTypeDumper(),
            new Dumper\PriceDumper(),
            new Dumper\WebFormDumper(),

            new Dumper\OrderPropertyGroupDumper(),
        ];
    }
}