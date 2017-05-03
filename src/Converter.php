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

}