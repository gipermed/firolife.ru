<?php


namespace Palladiumlab\Support\Bitrix;


use BadMethodCallException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Page\Asset;
use CUtil;
use Palladiumlab\Support\Util\Arr;
use Palladiumlab\Support\Util\Str;

/**
 * @method static \CMain globalApplication()
 * @method static \CUser globalUser()
 *
 * Class Bitrix
 * @package Palladiumlab\Support\Bitrix
 */
class Bitrix
{
    public static function restartBuffer(): void
    {
        global $APPLICATION;

        $APPLICATION->RestartBuffer();
        /** @noinspection PhpStatementHasEmptyBodyInspection */
        /** @noinspection LoopWhichDoesNotLoopInspection */
        /** @noinspection MissingOrEmptyGroupStatementInspection */
        while (ob_end_clean()) {

        }
    }

    /**
     * Метод подключает модули битрикса с обработкой ошибок
     *
     * @param array|string $modules
     * @return bool
     */
    public static function modules($modules): bool
    {
        if (!is_array($modules)) {
            $modules = explode(', ', $modules);
        }
        $modules = array_filter(array_unique(Arr::wrap($modules)));
        $successfully = true;

        foreach ($modules as $module) {
            if (empty($module)) {
                continue;
            }

            try {
                $includeResult = Loader::includeModule((string)$module);
                if (!$includeResult) {
                    $successfully = false;
                }
            } catch (LoaderException $e) {
                $successfully = false;
            }
        }

        return $successfully;
    }

    /**
     * Функция-обертка над Bitrix\Main\Page\Asset. Добавляет в <head/> скрипты, стили и произвольные строки
     * и возвращает экземпляр Bitrix\Main\Page\Asset.
     *
     * @see https://dev.1c-bitrix.ru/api_d7/bitrix/main/page/asset/
     *
     * @param string|array|null $resources Список подключаемых ресурсов.
     * Тип ресурса определяется по расширению файла. Поддерживаются .css и .js - ожидаются доступные web-пути.
     * Остальные ресурсы записываются в <head/> как обычные строки.
     *
     * @return Asset
     */
    public static function asset($resources = null): Asset
    {
        $assetManager = Asset::getInstance();

        if (!empty($resources)) {
            if (!is_array($resources)) {
                $resources = array($resources);
            }

            foreach ($resources as $resource) {
                if (Str::endsWith($resource, '.css')) {
                    $assetManager->addCss($resource);
                } elseif (Str::endsWith($resource, '.js')) {
                    $assetManager->addJs($resource);
                } else {
                    $assetManager->addString($resource);
                }
            }
        }

        return $assetManager;
    }

    public static function __callStatic($name, $arguments)
    {
        if (Str::startsWith(strtolower($name), 'global')) {
            $globalVariable = strtoupper(str_replace('global', '', strtolower($name)));

            global ${$globalVariable};

            return ${$globalVariable};
        }

        throw new BadMethodCallException("Method {$name} not found in " . __CLASS__);
    }

    /**
     * Метод возвращает транслит-версию переданной строки
     *
     * @param string $value Строка для транслитерации
     * @param array $options Массив параметров
     * @param string $lang Язык
     * @return string
     */
    public static function getTransliterate(string $value, array $options = [], string $lang = ''): string
    {
        $localOptions = array_merge([
            'max_len' => 100, // Максимальная длина полученной строки
            'change_case' => 'L', // 'L' - toLower, 'U' - toUpper, false - do not change Перевод строки в нужный регистр
            'replace_space' => '-', // Замена пробела
            'replace_other' => '-', // Замена остальных символов
            'delete_repeat_replace' => true, // Удаление повторяющихся символов замены
            'safe_chars' => '', // Символы, которые запрещённые для замены
        ], $options);

        return trim(CUtil::translit(
            $value,
            !empty($lang) ? $lang : LANGUAGE_ID,
            $localOptions
        ), " -_{$localOptions['replace_space']}{$localOptions['replace_other']}");
    }
}