<?php


namespace Palladiumlab\Support\File;


use CFile;
use Palladiumlab\Support\Bitrix\Cache;

class Image
{
    protected const CACHE_TIME = 60 * 60 * 24 * 30 * 3;

    public static function getResizePath(int $imageId, int $width, int $height, int $resizeType = BX_RESIZE_IMAGE_EXACT)
    {
        $size = ['width' => $width, 'height' => $height];

        return (new Cache(md5(__FUNCTION__) . "_{$imageId}", 'images/resize', self::CACHE_TIME))
            ->make(static function () use ($size, $imageId, $resizeType) {

                if ($imageId > 0) {
                    return CFile::ResizeImageGet($imageId, $size, $resizeType)['src'];
                }

                return CFile::GetFileArray($imageId)['SRC'];

            });
    }
}