<?php


namespace Palladiumlab\Support\Bitrix;


use Bitrix\Main\Application;
use Exception;
use ReflectionFunction;

class Cache
{
    protected int $time;
    protected string $path;
    protected string $key;

    public function __construct(string $key, string $path, int $time = 60 * 60)
    {
        $this->key = $key;
        $this->path = $path;
        $this->time = $time;
    }

    public function make(callable $callback)
    {
        $key = $this->resolveKey($callback);

        /** @var mixed $result */
        $result = null;

        try {
            /** @var Application $application */
            $application = Application::getInstance();

            $cache = $application->getCache();
            $taggedCache = $application->getTaggedCache();

            if ($cache->initCache($this->time, $key, $this->path)) {

                $result = $cache->getVars();

            } elseif ($cache->startDataCache($this->time, $key, $this->path)) {

                $taggedCache->startTagCache($this->path);
                $result = $callback($taggedCache, $key, $this->path, $this->time);

                if ($result === null) {
                    $taggedCache->abortTagCache();
                    $cache->abortDataCache();
                } else {
                    $taggedCache->endTagCache();
                    $cache->endDataCache($result);
                }

            }
        } catch (Exception $e) {
            return $result;
        }

        return $result;
    }

    protected function resolveKey(callable $callback): string
    {
        $key = $this->key;

        if (empty($key)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $rc = new ReflectionFunction($callback);

            $key = $rc->getFileName() . $rc->getStartLine();
        }

        return md5($key);
    }
}