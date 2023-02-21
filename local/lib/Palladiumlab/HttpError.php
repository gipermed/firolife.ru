<?php


namespace Palladiumlab;


use BadMethodCallException;
use Bitrix\Main\Application;
use Bitrix\Main\Page\Frame;
use CHTTP;
use CMain;

/**
 * @method static void make404()
 * @method static void notFound()
 *
 * @method static void make403()
 * @method static void forbidden()
 *
 * @method static void make500()
 * @method static void internalServerError()
 *
 *
 * Class HttpError
 * @package Palladiumlab
 */
class HttpError
{
    protected const ERROR_METHODS_ALIASES = [
        'make404' => ['notFound'],
        'make403' => ['forbidden'],
        'make500' => ['internalServerError'],
    ];

    protected const AVAILABLE_ERROR_METHODS = [
        'make404' => [404, '404 Not Found'],
        'make403' => [403, '403 Forbidden'],
        'make500' => [500, '500 Internal Server Error'],
    ];

    public static function __callStatic($name, $arguments)
    {
        if (array_key_exists($name, self::AVAILABLE_ERROR_METHODS)) {
            $method = $name;
        } else {
            foreach (self::ERROR_METHODS_ALIASES as $methodName => $aliases) {
                if (in_array($name, $aliases, true)) {
                    $method = $methodName;
                    break;
                }
            }
        }

        if (isset($method) && ($parameters = self::AVAILABLE_ERROR_METHODS[$method])) {
            static::make(...$parameters);
            return;
        }

        throw new BadMethodCallException("Method {$name} not found in " . __CLASS__);
    }

    protected static function make(int $code, string $status): void
    {
        /** @global CMain $APPLICATION */
        global $APPLICATION;

        if (!defined("ERROR_{$code}")) {
            define("ERROR_{$code}", 'Y');
        }

        CHTTP::setStatus($status);

        if ($APPLICATION->RestartWorkarea()) {

            if (!defined("BX_URLREWRITE")) {
                define("BX_URLREWRITE", true);
            }

            /** @noinspection PhpDeprecationInspection */
            Frame::setEnable(false);

            require(Application::getDocumentRoot() . "/{$code}.php");

            die();

        }
    }
}
