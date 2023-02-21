<?php


namespace Palladiumlab\Console\Commands\Cache;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Clear extends Command
{
	protected const BITRIX_PATH = ROOT_PATH . '/bitrix';
	protected static $defaultName = 'cache:clear';

	protected function configure()
	{
		$this->setDescription('Очистка кеша');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{


		$cacheDir = self::BITRIX_PATH . "/cache/";
		$managedCache = self::BITRIX_PATH . "/managed_cache/";
		$res = $this->removeDir($cacheDir);
		$output->writeln(PHP_EOL . "    <info>$res</info>" . PHP_EOL);
		$res = $this->removeDir($managedCache);
		$output->writeln(PHP_EOL . "    <info>$res</info>" . PHP_EOL);
		$output->writeln(PHP_EOL . "    <info>Команда завершена</info>" . PHP_EOL);

		return 0;
	}

	protected function removeDir($path)
	{
		if (file_exists($path) && is_dir($path))
		{
			$dirHandle = opendir($path);
			while (false !== ($file = readdir($dirHandle)))
			{
				if ($file != '.' && $file != '..')// исключаем папки с назварием '.' и '..'
				{
					$tmpPath = $path . '/' . $file;
					chmod($tmpPath, 0777);
					if (is_dir($tmpPath))
					{  // если папка
						$this->removeDir($tmpPath);
					} else
					{
						if (file_exists($tmpPath))
						{
							// удаляем файл
							unlink($tmpPath);
						}
					}
				}
			}
			closedir($dirHandle);
			// удаляем текущую папку
			if (file_exists($path))
			{
				rmdir($path);
			}
		} else
		{
			return "Удаляемой папки не существует или это файл!";
		}
		return "Удаление папки $path завершено";
	}
}