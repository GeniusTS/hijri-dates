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
     * Convert Gregorian date to Hijri date
     *
     * @param     $date
     * @param int $adjustment (days number)
     *
     * @return \GeniusTS\HijriDate\Date
     */
    public static function convertToHijri($date, int $adjustment = 0)
    {
        $static = new static;

        if (! $date instanceof Carbon)
        {
            $date = new Carbon($date);
        }

        return $static->toHijri($date, $adjustment);
    }

    /**
     * Convert Hijri date to Gregorian date
     *
     * @param int $day
     * @param int $month
     * @param int $year
     * @param int $adjustment (days number)
     *
     * @return Carbon
     */
    public static function convertToGregorian(int $day, int $month, int $year, int $adjustment = 0)
    {
        $static = new static;

        return $static->toGregorian($day, $month, $year, $adjustment);
    }

    /**
     * Convert Gregorian date to Hijri date
     *
     * @param \Carbon\Carbon $date
     * @param int            $adjustment
     *
     * @return \GeniusTS\HijriDate\Date
     */
    protected function toHijri(Carbon $date, int $adjustment = 0)
    {
        if ($adjustment)
        {
            $date->addDays($adjustment);
        }

        $jd = Converter::gregorianToJulian($date->year, $date->month, $date->day);
        $hijri = Converter::julianToHijri($jd);

        return new Date($hijri->day, $hijri->month, $hijri->year, $jd, $adjustment, clone $date);
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
    protected function toGregorian(int $day, int $month, int $year, int $adjustment = 0)
    {
        $jd = Converter::hijriToJulian($year, $month, $day);

        $date = Converter::julianToGregorian($jd);

        return (new Carbon("{$date->year}-{$date->month}-{$date->day}"))->addDays($adjustment);
    }
}

