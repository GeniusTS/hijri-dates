<?php

namespace GeniusTS\HijriDate;


use Carbon\Carbon;
use BadMethodCallException;
use InvalidArgumentException;
use GeniusTS\HijriDate\Translations\English;
use GeniusTS\HijriDate\Translations\TranslationInterface;

/**
 * Class Date
 *
 * @package       GeniusTS\HijriDate
 *
 * @property-read Carbon        $gregorian // return copy of gregorian date
 * @property-read float         $julianDay
 * @property-read int           $day
 * @property-read int           $month
 * @property-read int           $year
 * @property-read int           $yearIso
 * @property-read int           $hour
 * @property-read int           $minute
 * @property-read int           $second
 * @property-read int           $micro
 * @property-read int           $dayOfWeek
 * @property-read int           $timestamp
 * @property-read int           $offset
 * @property-read int           $offsetHours
 * @property-read bool          $dst
 * @property-read bool          $local
 * @property-read bool          $utc
 * @property-read \DateTimeZone $timezone
 * @property-read string        $timezoneName
 * @property-read string        $tzName
 * @method Date setDateTime($year, $month, $day, $hour, $minute, $second = 0)
 * @method Date setDate($year, $month, $day)
 * @method Date addDay(int $value = 1)
 * @method Date addDays(int $value)
 * @method Date subDay(int $value = 1)
 * @method Date subDays(int $value)
 * @method Date setTimestamp(int $unixtimestamp)
 * @method Date year(int $value)
 * @method Date month(int $value)
 * @method Date day(int $value)
 * @method Date timestamp(int $unixtimestamp)
 * @method Date addWeekdays(int $value)
 * @method Date addWeekday(int $value = 1)
 * @method Date subWeekday(int $value = 1)
 * @method Date subWeekdays(int $value)
 * @method Date addWeeks(int $value)
 * @method Date addWeek(int $value = 1)
 * @method Date subWeek(int $value = 1)
 * @method Date subWeeks(int $value)
 * @method Date addHours(int $value)
 * @method Date addHour(int $value = 1)
 * @method Date subHour(int $value = 1)
 * @method Date subHours(int $value)
 * @method Date addMinutes(int $value)
 * @method Date addMinute(int $value = 1)
 * @method Date subMinute(int $value = 1)
 * @method Date subMinutes(int $value)
 * @method Date addSeconds(int $value)
 * @method Date addSecond(int $value = 1)
 * @method Date subSecond(int $value = 1)
 * @method Date subSeconds(int $value)
 * @method Date startOfWeek()
 * @method Date endOfWeek()
 * @method Date next($dayOfWeek = null)
 * @method Date nextOrPreviousDay($weekday = true, $forward = true)
 * @method Date nextWeekday()
 * @method Date previousWeekday()
 * @method Date nextWeekendDay()
 * @method Date previousWeekendDay()
 * @method Date previous()
 * @method Date startOfDay()
 * @method Date setTime($hour, $minute, $second = 0, $microseconds = 0)
 * @method Date setTimezone(\DateTimeZone | string $value)
 * @method Date hour(int $value)
 * @method Date minute(int $value)
 * @method Date second(int $value)
 * @method Date setTimeFromTimeString(string $time)
 * @method Date timezone(\DateTimeZone | string $value)
 * @method Date tz(\DateTimeZone | string $value)
 * @method bool eq(Carbon | Date $dt)
 * @method bool equalTo(Carbon | Date $dt)
 * @method bool ne(Carbon | Date $dt)
 * @method bool notEqualTo(Carbon | Date $dt)
 * @method bool gt(Carbon | Date $dt)
 * @method bool greaterThan(Carbon | Date $dt)
 * @method bool gte(Carbon | Date $dt)
 * @method bool greaterThanOrEqualTo(Carbon | Date $dt)
 * @method bool lt(Carbon | Date $dt)
 * @method bool lessThan(Carbon | Date $dt)
 * @method bool lte(Carbon | Date $dt)
 * @method bool lessThanOrEqualTo(Carbon | Date $dt)
 * @method bool between(Carbon | Date $dt1, Carbon | Date $dt2, $equal = true)
 * @method bool isWeekday()
 * @method bool isWeekend()
 * @method bool isYesterday()
 * @method bool isToday()
 * @method bool isTomorrow()
 * @method bool isNextWeek()
 * @method bool isLastWeek()
 * @method bool isFuture()
 * @method bool isPast()
 * @method bool isSunday()
 * @method bool isMonday()
 * @method bool isTuesday()
 * @method bool isWednesday()
 * @method bool isThursday()
 * @method bool isFriday()
 * @method bool isSaturday()
 * @method static Date now(\DateTimeZone | string | null $tz = null)
 * @method static Date today(\DateTimeZone | string | null $tz = null)
 * @method static Date tomorrow(\DateTimeZone | string | null $tz = null)
 * @method static Date yesterday(\DateTimeZone | string | null $tz = null)
 */
class Date
{

    /* allowed numbers values */
    const ARABIC_NUMBERS = 0;
    const INDIAN_NUMBERS = 1;

    /**
     * @var string
     */
    protected static $toStringFormat = 'Y-m-d H:i:s';

    /**
     * @var int
     */
    protected static $default_numbers = Date::ARABIC_NUMBERS;

    /**
     * Available formats
     *
     * @var array
     */
    protected $formats = [
        'L',
        'N',
        'w',
        'L',
        'B',
        'g',
        'G',
        'h',
        'H',
        'i',
        's',
        'u',
        'e',
        'I',
        'O',
        'P',
        'T',
        'Z',
        'U',
    ];

    /**
     * Indian numbers
     *
     * @var array
     */
    protected $indianNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

    /**
     * Arabic numbers
     *
     * @var array
     */
    protected $arabicNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

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
    protected $adjustment = 0;

    /**
     * @var \GeniusTS\HijriDate\Translations\TranslationInterface
     */
    protected static $translation;

    /**
     * Values of date object
     *
     * @var array
     */
    protected $values = [];

    /**
     * Date constructor.
     *
     * @param int                 $day   // Hijri day
     * @param int                 $month // Hijri month
     * @param int                 $year  // Hijri year
     * @param float               $julianDay
     * @param \Carbon\Carbon|null $date
     * @param int                 $adjustment
     */
    public function __construct(int $day,
        int $month,
        int $year,
        float $julianDay = 0,
        Carbon $date = null,
        int $adjustment = 0)
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->julianDay = $julianDay ?: Converter::hijriToJulian($year, $month, $day);
        $this->date = $date ?: new Carbon(implode('-', (array) Converter::julianToGregorian($this->julianDay)));
        $this->adjustment = $adjustment;

        if (! static::$translation)
        {
            static::setTranslation(new English);
        }

        $this->fillValuesArray();
    }

    /**
     * Change translation class
     *
     * @param \GeniusTS\HijriDate\Translations\TranslationInterface $translation
     */
    public static function setTranslation(TranslationInterface $translation)
    {
        static::$translation = $translation;
    }

    /**
     * get default adjustment value
     *
     * @return int
     */
    public function getAdjustment()
    {
        return $this->adjustment;
    }

    /**
     * Change default adjustment value
     *
     * @param int $adjustment
     */
    public function setAdjustment(int $adjustment)
    {
        $this->adjustment = $adjustment;
    }

    /**
     * get default numeric system
     *
     * @return int
     */
    public static function getDefaultNumbers()
    {
        return static::$default_numbers;
    }

    /**
     * Change default numeric system
     *
     * @param int $numbers
     */
    public static function setDefaultNumbers(int $numbers)
    {
        static::$default_numbers = $numbers;
    }

    /**
     * get the default format
     *
     * @return string
     */
    public static function getToStringFormat()
    {
        return static::$toStringFormat;
    }

    /**
     * Set the default format
     *
     * @param string $format
     */
    public static function setToStringFormat($format)
    {
        static::$toStringFormat = $format;
    }

    /**
     * get date string
     *
     * @param string $format
     * @param int    $numbers
     *
     * @return string
     */
    public function format(string $format = null, int $numbers = null)
    {
        $numbers = $numbers === null ? static::getDefaultNumbers() : $numbers;
        $format = $format === null ? static::getToStringFormat() : $format;

        $formatArray = str_split($format);
        $dateString = '';

        foreach ($formatArray as $key => $value)
        {
            if (key_exists($value, $this->values))
            {
                $dateString .= $this->values[$value];
                continue;
            }

            $dateString .= $value;
        }

        if ($numbers === static::INDIAN_NUMBERS)
        {
            $dateString = str_replace($this->arabicNumbers, $this->indianNumbers, $dateString);
        }

        return $dateString;
    }

    /**
     * recalculate hijri date
     *
     * @return static
     */
    protected function recalculate()
    {
        $adjusted = (new Carbon($this->date))->addDays($this->adjustment);

        $julian = Converter::gregorianToJulian($adjusted->year, $adjusted->month, $adjusted->day);

        $hijri = Converter::julianToHijri($julian);

        $this->julianDay = $julian;
        $this->day = $hijri->day;
        $this->month = $hijri->month;
        $this->day = $hijri->day;

        return $this->fillValuesArray();
    }

    /**
     * Fill formats values
     *
     * @return static
     */
    protected function fillValuesArray()
    {
        $this->values['j'] = $this->day;
        $this->values['d'] = str_pad($this->day, 2, 0, STR_PAD_LEFT);
        $this->values['D'] = static::$translation->getShortDays()[$this->date->dayOfWeek];
        $this->values['l'] = static::$translation->getDays()[$this->date->dayOfWeek];

        $this->values['n'] = $this->month;
        $this->values['m'] = str_pad($this->month, 2, 0, STR_PAD_LEFT);
        $this->values['M'] = static::$translation->getHijriMonths()[$this->month - 1];
        $this->values['F'] = static::$translation->getHijriMonths()[$this->month - 1];

        $this->values['o'] = $this->year;
        $this->values['y'] = substr($this->year, 0, 2);
        $this->values['Y'] = str_pad($this->year, 4, 0, STR_PAD_LEFT);

        $this->values['a'] = $this->date->hour >= 12 ? static::$translation->getPeriods()[1] : static::$translation->getPeriods()[0];
        $this->values['A'] = strtoupper($this->date->hour >= 12 ? static::$translation->getPeriods()[1] : static::$translation->getPeriods()[0]);

        $this->fillCarbonValues();

        return $this;
    }

    /**
     * get format values from carbon instance
     *
     * @return $this
     */
    protected function fillCarbonValues()
    {
        foreach ($this->formats as $format)
        {
            $this->values[$format] = $this->date->format($format);
        }

        return $this;
    }

    /**
     * Get the days of the week
     *
     * @return array
     */
    public static function getDays()
    {
        return static::$translation->getDays();
    }

    /**
     * simulate Comparision function od Carbon class
     *
     * @param string $function
     * @param array  $arguments
     */
    protected function comparision($function, array $arguments)
    {
        $args = [];

        foreach ($arguments as $argument)
        {
            if ($argument instanceof Date)
            {
                $args[] = $argument->gregorian;
            }
            elseif ($argument instanceof Carbon)
            {
                $args[] = $argument;
            }
            else
            {
                throw new InvalidArgumentException(
                    sprintf("date must be instance of %s or %s", Carbon::class, static::class)
                );
            }
        }

        return $this->date->{$function}(...$args);
    }

    /**
     * Get attributes value
     *
     * @param $attribute
     *
     * @return mixed
     */
    public function __get($attribute)
    {
        switch ($attribute)
        {
            case 'julianDay':
                return $this->{$attribute};
            case 'gregorian':
                return clone $this->date;
            case 'hour':
            case 'minute':
            case 'second':
            case 'micro':
            case 'dayOfWeek':
            case 'timestamp':
            case 'offset':
            case 'offsetHours':
            case 'dst':
            case 'local':
            case 'utc':
            case 'timezone':
            case 'timezoneName':
            case 'tzName':
                return $this->date->{$attribute};
            case 'year':
                return $this->values['Y'];
            case 'yearIso':
                return $this->values['o'];
            case 'month':
                return $this->values['n'];
            case 'day':
                return $this->values['j'];
            default:
                throw new InvalidArgumentException("Undefined property '{$attribute}'");
        }
    }

    /**
     * Call functions of Carbon instance
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        switch ($name)
        {
            case 'setDateTime':
            case 'setDate':
            case 'addDay':
            case 'addDays':
            case 'subDay':
            case 'subDays':
            case 'setTimestamp':
            case 'year':
            case 'month':
            case 'day':
            case 'timestamp':
            case 'addWeekdays':
            case 'addWeekday':
            case 'subWeekday':
            case 'subWeekdays':
            case 'addWeeks':
            case 'addWeek':
            case 'subWeek':
            case 'subWeeks':
            case 'addHours':
            case 'addHour':
            case 'subHour':
            case 'subHours':
            case 'addMinutes':
            case 'addMinute':
            case 'subMinute':
            case 'subMinutes':
            case 'addSeconds':
            case 'addSecond':
            case 'subSecond':
            case 'subSeconds':
            case 'endOfWeek':
            case 'startOfWeek':
            case 'next':
            case 'nextOrPreviousDay':
            case 'nextWeekday':
            case 'previousWeekday':
            case 'nextWeekendDay':
            case 'previousWeekendDay':
            case 'previous':
                $this->date->{$name}(...$arguments);

                return $this->recalculate();
            case 'startOfDay':
            case 'setTime':
            case 'setTimezone':
            case 'hour':
            case 'minute':
            case 'second':
            case 'setTimeFromTimeString':
            case 'timezone':
            case 'tz':
                $this->date->{$name}(...$arguments);

                return $this->fillCarbonValues();
            case 'eq':
            case 'equalTo':
            case 'ne':
            case 'notEqualTo':
            case 'gt':
            case 'greaterThan':
            case 'gte':
            case 'greaterThanOrEqualTo':
            case 'lt':
            case 'lessThan':
            case 'lte':
            case 'lessThanOrEqualTo':
            case 'between':
                return $this->comparision($name, $arguments);
            case 'isWeekday':
            case 'isWeekend':
            case 'isYesterday':
            case 'isToday':
            case 'isTomorrow':
            case 'isNextWeek':
            case 'isLastWeek':
            case 'isFuture':
            case 'isPast':
            case 'isSunday':
            case 'isMonday':
            case 'isTuesday':
            case 'isWednesday':
            case 'isThursday':
            case 'isFriday':
            case 'isSaturday':
                return $this->date->{$name}(...$arguments);

            default:
                throw new BadMethodCallException("Undefined '{$name}' method!");
        }
    }

    /**
     * Call functions of Carbon instance
     *
     * @param $name
     * @param $arguments
     *
     * @return static
     */
    public static function __callStatic($name, $arguments)
    {
        switch ($name)
        {
            case 'now':
            case 'today':
            case 'tomorrow':
            case 'yesterday':
                $date = Carbon::{$name}(...$arguments);

                return Hijri::convertToHijri($date);
            default:
                throw new BadMethodCallException("Undefined '{$name}' method!");
        }
    }

    /**
     * Format the instance as a string using the set format
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format(static::$toStringFormat);
    }

}