<?php


namespace Palladiumlab\Console\Schedule;


use Crunz\Event as CrunzEvent;

/**
 * @method self everyTenMinutes() Run task every ten minutes.
 * @method self everySixMinutes() Run task every six minutes.
 * @method self everyFourMinutes() Run task every four minutes.
 * @method self everyTwoMinutes() Run task every two minutes.
 *
 * @method self everyTenHours() Run task every ten hours.
 * @method self everySixHours() Run task every six hours.
 * @method self everyFourHours() Run task every four hours.
 * @method self everyTwoHours() Run task every two hours.
 *
 * @method self everyTenDays() Run task every ten days.
 * @method self everySixDays() Run task every six days.
 * @method self everyFourDays() Run task every four days.
 * @method self everyTwoDays() Run task every two days.
 *
 * @method self everyTenMonth() Run task every ten months.
 * @method self everySixMonth() Run task every six months.
 * @method self everyFourMonth() Run task every four months.
 * @method self everyTwoMonth() Run task every two months.
 *
 * Класс-обёртка над библиотекой Crunz\Event
 * добавляет объявление магических методов для удобства
 *
 * Class Event
 * @package Palladiumlab\Console\Schedule
 */
class Event extends CrunzEvent
{

}
