<?php

namespace GeniusTS\HijriDate\Translations;


/**
 * Class Persian
 *
 * @package GeniusTS\HijriDate\Translations
 */
class Persian implements TranslationInterface
{

    /**
     * Hijri Months names
     *
     * @var array
     */
    protected $hijriMonths = [
        'محرم',
        'صفر',
        'ربیع الاول',
        'ربیع الثانی',
        'جمادی الاول',
        'جمادی الثانی',
        'رجب',
        'شعبان',
        'رمضان',
        'شوال',
        'ذی القعده',
        'ذی الحجه',
    ];

    /**
     * short days
     *
     * @var array
     */
    protected $shortDays = ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه', 'شنبه'];

    /**
     * days names
     *
     * @var array
     */
    protected $days = ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه', 'شنبه'];

    /**
     * periods
     *
     * @var array
     */
    protected $periods = ['ق.ظ', 'ب.ظ'];

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