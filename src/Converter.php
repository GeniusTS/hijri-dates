<?php

namespace GeniusTS\HijriDate;


/**
 * Class Converter
 *
 * @package GeniusTS\HijriDate
 */
class Converter
{

    /**
     * The Julian Day for a given Gregorian date.
     *
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return float
     */
    public static function gregorianToJulian(int $year, int $month, int $day)
    {
        if ($month < 3)
        {
            $year -= 1;
            $month += 12;
        }

        $a = floor($year / 100.0);
        $b = ($year === 1582 && ($month > 10 || ($month === 10 && $day > 4)) ? -10 :
            ($year === 1582 && $month === 10 ? 0 :
                ($year < 1583 ? 0 : 2 - $a + floor($a / 4.0))));

        return floor(365.25 * ($year + 4716)) + floor(30.6001 * ($month + 1)) + $day + $b - 1524;
    }

    /**
     * The Julian Day for a given Hijri date.
     *
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return float
     */
    public static function hijriToJulian(int $year, int $month, int $day)
    {
        return floor((11 * $year + 3) / 30) + floor(354 * $year) + floor(30 * $month)
            - floor(($month - 1) / 2) + $day + 1948440 - 386;
    }

    /**
     * The Gregorian date Day for a given Julian
     *
     * @param float $julianDay
     *
     * @return \stdClass
     */
    public static function julianToGregorian(float $julianDay)
    {
        $b = 0;
        if ($julianDay > 2299160)
        {
            $a = floor(($julianDay - 1867216.25) / 36524.25);
            $b = 1 + $a - floor($a / 4.0);
        }

        $bb = $julianDay + $b + 1524;
        $cc = floor(($bb - 122.1) / 365.25);
        $dd = floor(365.25 * $cc);
        $ee = floor(($bb - $dd) / 30.6001);

        $day = ($bb - $dd) - floor(30.6001 * $ee);
        $month = $ee - 1;

        if ($ee > 13)
        {
            $cc += 1;
            $month = $ee - 13;
        }

        $year = $cc - 4716;

        return (object) ['year' => (int) $year, 'month' => (int) $month, 'day' => (int) $day];
    }

    /**
     * The Hijri date Day for a given Julian
     *
     * @param float $julianDay
     *
     * @return \stdClass
     */
    public static function julianToHijri(float $julianDay)
    {
        $y = 10631.0 / 30.0;
        $epochAstro = 1948084;
        $shift1 = 8.01 / 60.0;

        $z = $julianDay - $epochAstro;
        $cyc = floor($z / 10631.0);
        $z = $z - 10631 * $cyc;
        $j = floor(($z - $shift1) / $y);
        $z = $z - floor($j * $y + $shift1);

        $year = 30 * $cyc + $j;
        $month = (int)floor(($z + 28.5001) / 29.5);
        if ($month === 13)
        {
            $month = 12;
        }

        $day = $z - floor(29.5001 * $month - 29);

        return (object) ['year' => (int) $year, 'month' => (int) $month, 'day' => (int) $day];
    }
}
