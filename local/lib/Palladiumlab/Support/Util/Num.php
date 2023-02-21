<?php


namespace Palladiumlab\Support\Util;


class Num
{
    public static function formatPrecision(
        float $number,
        int $precision = 2,
        string $separator = ',',
        string $thousandsSeparator = ''
    ): string
    {
        $powPrecision = (10 ** $precision);

        return number_format(
            (int)($number * $powPrecision) / $powPrecision,
            $precision,
            $separator,
            $thousandsSeparator
        );
    }

    public static function parseFloat(string $number): float
    {
        return (float)str_replace([',', ' '], ['.', ''], $number);
    }

    public static function formatThousand(float $number): string
    {
        return number_format($number, 0, ',', ' ');
    }

    public static function formatCurrency(float $number, $currency = 'RUB'): string
    {
        return str_replace(' ', '&nbsp;', SaleFormatCurrency($number, $currency));
    }
}