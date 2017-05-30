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
        // reference https://en.wikipedia.org/wiki/Julian_day
        $a = floor((14 - $month) / 12);
        $y = $year + 4800 - $a;
        $m = $month + (12 * $a) - 3;

        return $day + floor(((153 * $m) + 2) / 5)
            + (365 * $y) + floor($y / 4) - floor($y / 100)
            + floor($y / 400) - 32045;
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
        $month = floor(($z + 28.5001) / 29.5);
        if ($month === 13)
        {
            $month = 12;
        }
        $day = $z - floor(29.5001 * $month - 29);

        return (object) ['year' => (int) $year, 'month' => (int) $month, 'day' => (int) $day];
    }
}