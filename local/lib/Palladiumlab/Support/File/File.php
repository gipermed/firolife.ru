<?php


namespace Palladiumlab\Support\File;


use CFile;
use Illuminate\Support\Collection;
use Palladiumlab\Support\Bitrix\Cache;
use Palladiumlab\Support\Bitrix\Resource;
use Palladiumlab\Support\Util\Arr;

class File
{
    public const CACHE_TIME = 60 * 60 * 24 * 30;

    /**
     * @param int[]|int $files
     * @return Collection
     */
    public static function getInfo($files): Collection
    {
        $files = array_filter(Arr::wrap($files), 'is_numeric');

        $result = static::getFilesInfo($files);

//        if (count($files) === 1) {
//            return reset($result) ?: [];
//        }

        return new Collection($result);
    }

    protected static function getFilesInfo(array $fileIdList): array
    {
        if (empty($fileIdList)) {
            return [];
        }

        return (new Cache(serialize(['files_info' => $fileIdList]), 'files_info/', self::CACHE_TIME))
            ->make(static function () use ($fileIdList) {
                $files = (new Resource(CFile::GetList([], ['@ID' => $fileIdList])))->toArray();
                $files = Arr::combineKeys($files, 'ID');

                foreach ($files as &$file) {
                    if ($file['~src']) {
                        $file['SRC'] = $file['~src'];
                    } else {
                        $file['SRC'] = CFile::GetFileSRC($file, false, false);
                    }
                }

                return $files;
            });
    }
}