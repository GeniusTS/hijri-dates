<?php

namespace GeniusTS\HijriDate;


use Carbon\Carbon;

/**
 * Class Hijri
 *
 * @package GeniusTS\HijriDate
 */
class Hijri
{

    /**
     * Default adjustment
     *
     * @var int
     */
    protected static $adjustment = 0;

    /**
     * Convert Gregorian date to Hijri date
     *
     * @param          $date
     * @param int|null $adjustment
     *
     * @return \GeniusTS\HijriDate\Date
     */
    public static function convertToHijri($date, int $adjustment = null)
    {
        if (! $date instanceof Carbon)
        {
            $date = new Carbon($date);
        }

        return static::toHijri($date, static::getAdjustment($adjustment));
    }

    /**
     * Convert Hijri date to Gregorian date
     *
     * @param int      $day
     * @param int      $month
     * @param int      $year
     * @param int|null $adjustment
     *
     * @return \Carbon\Carbon
     */
    public static function convertToGregorian(int $day, int $month, int $year, int $adjustment = null)
    {
        return static::toGregorian($day, $month, $year, static::getAdjustment($adjustment));
    }

    /**
     * Convert Gregorian date to Hijri date
     *
     * @param \Carbon\Carbon $date
     * @param int            $adjustment
     *
     * @return \GeniusTS\HijriDate\Date
     */
    protected static function toHijri(Carbon $date, int $adjustment = 0)
    {
        $adjusted = (new Carbon($date))->addDays($adjustment);

        $jd = Converter::gregorianToJulian($adjusted->year, $adjusted->month, $adjusted->day);
        $hijri = Converter::julianToHijri($jd);

        return new Date($hijri->day, $hijri->month, $hijri->year, $jd, clone $date, $adjustment);
    }

    /**
     * Convert Hijri date to Gregorian date
     *
     * @param int $day
     * @param int $month
     * @param int $year
     * @param int $adjustment
     *
     * @return Carbon
     */
    protected static function toGregorian(int $day, int $month, int $year, int $adjustment = 0)
    {
        $jd = Converter::hijriToJulian($year, $month, $day);

        $date = Converter::julianToGregorian($jd);

        return (new Carbon("{$date->year}-{$date->month}-{$date->day}"))->addDays(-1 * $adjustment);
    }

    /**
     * get default adjustment
     *
     * @return int
     */
    public static function getDefaultAdjustment()
    {
        return static::$adjustment;
    }

    /**
     * Set default adjustment
     *
     * @param int $adjustment
     */
    public static function setDefaultAdjustment(int $adjustment)
    {
        static::$adjustment = $adjustment;
    }

    /**
     * Get adjustment days
     *
     * @param int|null $adjustment
     *
     * @return int
     */
    protected static function getAdjustment(int $adjustment = null)
    {
        return $adjustment === null ? static::getDefaultAdjustment() : $adjustment;
    }
}


