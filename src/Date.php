<?php

namespace GeniusTS\HijriDate;


use Carbon\Carbon;

/**
 * Class Date
 *
 * @package GeniusTS\HijriDate
 *
 * @property-read Carbon $date
 * @property-read float  $julianDay
 * @property-read int    $day
 * @property-read int    $month
 * @property-read int    $year
 */
class Date
{

    /**
     * @var Carbon
     */
    protected $date;

    /**
     * @var float
     */
    protected $julianDay;

    /**
     * @var int
     */
    protected $day;

    /**
     * @var int
     */
    protected $month;

    /**
     * @var int
     */
    protected $year;

    /**
     * @var int
     */
    protected $adjustment;

    /**
     * Date constructor.
     *
     * @param int                 $day
     * @param int                 $month
     * @param int                 $year
     * @param float               $julianDay
     * @param int                 $adjustment
     * @param \Carbon\Carbon|null $date
     */
    public function __construct(int $day,
        int $month,
        int $year,
        float $julianDay,
        int $adjustment = 0,
        Carbon $date = null)
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->julianDay = $julianDay;
        $this->date = $date ?: new Carbon(implode('-', (array) Converter::jdToGregorian($julianDay)));
        $this->adjustment = $adjustment;
    }

    /**
     * @param $attribute
     *
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->{$attribute};
    }
}