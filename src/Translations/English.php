<?php

namespace GeniusTS\HijriDate\Translations;


/**
 * Class English
 *
 * @package GeniusTS\HijriDate\Translations
 */
class English implements TranslationInterface
{

    /**
     * Hijri Months names
     *
     * @var array
     */
    protected $hijriMonths = [
        'Muḥarram',
        'Ṣafar',
        'Rabi‘ al-awwal',
        'Rabi‘ at-akhir',
        'Jumada al-ula',
        'Jumada al-akhirah',
        'Rajab',
        'Sha‘ban',
        'Ramadan',
        'Shawwal',
        'Thu al-Qa‘dah',
        'Thu al-Hijjah',
    ];

    /**
     * short days
     *
     * @var array
     */
    protected $shortDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    /**
     * days names
     *
     * @var array
     */
    protected $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

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