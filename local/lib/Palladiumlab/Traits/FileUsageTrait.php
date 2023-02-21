<?php


namespace Palladiumlab\Traits;


use BadMethodCallException;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @method SplFileInfo moveFileToProcess(SplFileInfo $file, string $baseDirectory)
 * @method SplFileInfo moveFileToArchive(SplFileInfo $file, string $baseDirectory)
 * @method SplFileInfo moveFileToError(SplFileInfo $file, string $baseDirectory)
 *
 * Trait FileUsageTrait
 * @package Palladiumlab\Traits
 */
trait FileUsageTrait
{
    public function __call($name, $arguments)
    {
        if (Str::startsWith($name, 'moveFileTo')) {
            [$file, $baseDirectory] = [
                $arguments[0],
                $arguments[1],
            ];

            $toDirectory = strtolower(str_replace('moveFileTo', '', $name));

            $changeName = true;
            if ($toDirectory === 'process') {
                $changeName = false;
            }

            return $this->moveTo($file, $baseDirectory, $toDirectory, $changeName);
        }

        throw new BadMethodCallException("Method {$name} not found in " . __CLASS__);
    }

    protected function moveTo(SplFileInfo $file, string $baseDirectory, string $toDirectory, $changeName = true)
    {
        if (file_exists($baseDirectory) && is_dir($baseDirectory)) {
            $io = new Filesystem();
            $archivePath = rtrim($baseDirectory, '/') . "/{$toDirectory}/";

            if (!file_exists($archivePath)) {
                $io->mkdir($archivePath, 0775);
            }

            if ($changeName) {
                $fileName = str_replace(".{$file->getExtension()}", '', $file->getFilename());
                $fileName .= '_' . date('Y-m-d__H-i-s') . ".{$file->getExtension()}";
            } else {
                $fileName = $file->getFilename();
            }

            $targetFile = $archivePath . $fileName;

            if ($io->exists($targetFile)) {
                $io->remove($targetFile);
            }

            $io->rename($file->getRealPath(), $targetFile);

            if (method_exists($this, 'info')) {
                $this->info("File moved to {$toDirectory}", ['file' => $file->getFilename()]);
            }

            return new SplFileInfo($targetFile, '', $fileName);
        }

        return $file;
    }

    /**
     * @param string $directory
     * @param string $filePattern
     * @return Finder
     */
    protected function findFiles(string $directory, string $filePattern)
    {
        if (!file_exists($directory)) {
            (new Filesystem())->mkdir($directory, 0775);
        }

        $finder = new Finder();

        if (method_exists($this, 'info')) {
            $this->info("Checking directory", ['path' => $directory]);
            $this->info("Find files", ['pattern' => $filePattern]);
        }

        if (is_dir($directory)) {
            $finder
                ->depth(0)
                ->files()
                ->in($directory)
                ->name($filePattern);

            if (method_exists($this, 'info')) {
                $this->info("Founded {$finder->count()} files");
            }

            return $finder;
        }

        throw new RuntimeException('Directory does not exist');
    }
}
