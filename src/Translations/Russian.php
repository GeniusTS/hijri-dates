<?php

namespace GeniusTS\HijriDate\Translations;


/**
 * Class Russian
 *
 * @package GeniusTS\HijriDate\Translations
 */
class Russian implements TranslationInterface
{

    /**
     * Hijri Months names
     *
     * @var array
     */
    protected $hijriMonths = [
        'Мухаррам',
        'Сафар',
        'Раби аль-авваль',
        'Раби ас-сани',
        'Джумада аль-уля',
        'Джумада ас-сани',
        'Раджаб',
        'Шабан',
        'Рамадан',
        'Шавваль',
        'Зу-ль-када',
        'Зу-ль-хиджа',
    ];

    /**
     * short days
     *
     * @var array
     */
    protected $shortDays = ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'];

    /**
     * days names
     *
     * @var array
     */
    protected $days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];

    /**
     * periods
     *
     * @var array
     */
    protected $periods = ['am', 'pm'];

    /**
     * get array of months names
     *
     * @return array
     */
    public function getHijriMonths(): array
    {
        return $this->hijriMonths;
    }

    /**
     * get array of short days names
     * started from Sunday
     *
     * @return array
     */
    public function getShortDays(): array
    {
        return $this->shortDays;
    }

    /**
     * get array of months names
     * started from Sunday
     *
     * @return array
     */
    public function getDays(): array
    {
        return $this->days;
    }

    /**
     * get array of periods
     *
     * @return array
     */
    public function getPeriods(): array
    {
        return $this->periods;
    }
}