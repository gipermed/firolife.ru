<?php


namespace Palladiumlab\Support\Util;


use Illuminate\Support\Str as IlluminateStr;

class Str extends IlluminateStr
{
    /**
     * Function converts array of css-classes into string with following rules:
     * ['b-user', 'b-user--logged' => true, 'b-user--admin' => false] => 'b-user b-user--logged'
     * @param array $classes
     * @return string
     * @noinspection PhpUnnecessaryBoolCastInspection
     */
    public static function classList(array $classes): string
    {
        return implode(' ', array_filter(array_map(static function ($condition, $class) {

            if (is_int($class) && is_string($condition)) {
                return $condition;
            }

            if ((bool)$condition && !empty($class)) {
                return $class;
            }

            return false;

        }, $classes, array_keys($classes))));
    }

    /**
     * Функция возвращает правильную множественную форму слова для русского языка.
     *
     * @param int $number
     * @param string|array $msg - массив множественных форм, либо строка, разделенная знаком |
     * @return string
     *
     * <code>
     * echo plural(1, 'комментарий|комментария|комментариев'); // комментарий
     * echo plural(2, 'комментарий|комментария|комментариев'); // комментария
     * echo plural(5, array('комментарий', 'комментария', 'комментариев')) ; // комментариев
     * </code>
     */
    public static function pluralRussian(int $number, $msg): string
    {
        $number = (int)abs($number);
        if (!is_array($msg)) {
            $msg = explode('|', $msg);
        }

        // эти правила корректны для русского языка. для других языков будет другая математика.
        if ($number % 10 === 1 && $number % 100 !== 11) {
            $key = 0;
        } elseif ($number % 10 >= 2 && $number % 10 <= 4 && ($number % 100 < 10 || $number % 100 >= 20)) {
            $key = 1;
        } else {
            $key = 2;
        }

        return $msg[$key];
    }

    public static function phone(string $string): string
    {
        $phone = preg_replace('/\D+/', '', $string);

        return static::startsWith($phone, '7') ? "+{$phone}" : $phone;
    }
}