<?php

namespace GeniusTS\HijriDate\Translations;


/**
 * Class Indonesian
 *
 * @package GeniusTS\HijriDate\Translations
 */
class Indonesian implements TranslationInterface
{

    /**
     * Hijri Months names
     *
     * @var array
     */
    protected $hijriMonths = [
        'Muharam',
        'Ṣafar',
        'Rabiulawal',
        'Rabiulakhir',
        'Jumadilawal',
        'Jumadilakhir',
        'Rajab',
        'Syakban',
        'Ramadan',
        'Syawal',
        'Zulkaidah',
        'Zulhijah',
    ];

    /**
     * short days
     *
     * @var array
     */
    protected $shortDays = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

    /**
     * days names
     *
     * @var array
     */
    protected $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    /**
     * periods
     *
     * @var array
     */
    protected $periods = ['pagi', 'petang'];

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
