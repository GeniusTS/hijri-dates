<?php

namespace GeniusTS\HijriDate\Translations;


/**
 * Class Malay (Malaysia) ms_MY
 *
 * @package GeniusTS\HijriDate\Translations
 */
class Malay implements TranslationInterface
{

    /**
     * Hijri Months names
     *
     * @var array
     */
    protected $hijriMonths = [
        'Muharram',
        'Ṣafar',
        'Rabi\'ulawal',
        'Rabi\'ulakhir',
        'Jamadilawwal',
        'Jamadilakhir',
        'Rajab',
        'Sya\'ban',
        'Ramadhan',
        'Shawwal',
        'Zulkaedah',
        'Zulhijjah',
    ];

    /**
     * short days
     *
     * @var array
     */
    protected $shortDays = ['Ahd', 'Isn', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

    /**
     * days names
     *
     * @var array
     */
    protected $days = ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'];

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
