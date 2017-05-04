<?php

namespace GeniusTS\HijriDate;


use Carbon\Carbon;
use InvalidArgumentException;
use GeniusTS\HijriDate\Translations\English;
use GeniusTS\HijriDate\Translations\TranslationInterface;

/**
 * Class Date
 *
 * @package GeniusTS\HijriDate
 *
 * @property-read Carbon $gregorian // return copy of gregorian date
 * @property-read float  $julianDay
 * @property-read int    $day
 * @property-read int    $month
 * @property-read int    $year
 * @property-read int    $yearIso
 * @property-read int    $hour
 * @property-read int    $minute
 * @property-read int    $second
 * @property-read int    $micro
 * @property-read int    $dayOfWeek
 * @property-read int    $timestamp
 */
class Date
{

    /* allowed numbers values */
    const ARABIC_NUMBERS = 0;
    const INDIAN_NUMBERS = 1;

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
        'I' .
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
    protected $adjustment;

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
     * @param int                 $adjustment
     * @param \Carbon\Carbon|null $date
     */
    public function __construct(int $day,
        int $month,
        int $year,
        float $julianDay = 0,
        int $adjustment = 0,
        Carbon $date = null)
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
     * Get a date instance for the current date and time.
     *
     * @param \DateTimeZone|string|null $tz
     * @param int                       $adjustment
     *
     * @return static
     */
    public static function now($tz = null, int $adjustment = 0)
    {
        $carbon = new Carbon(null, $tz);

        return Hijri::convertToHijri($carbon, $adjustment);
    }

    /**
     * Create a date instance for today.
     *
     * @param \DateTimeZone|string|null $tz
     * @param int                       $adjustment
     *
     * @return static
     */
    public static function today($tz = null, int $adjustment = 0)
    {
        return static::now($tz, $adjustment)->startOfDay();
    }

    /**
     * Create a date instance for tomorrow.
     *
     * @param \DateTimeZone|string|null $tz
     * @param int                       $adjustment
     *
     * @return static
     */
    public static function tomorrow($tz = null, int $adjustment = 0)
    {
        return static::today($tz, $adjustment)->addDay();
    }

    /**
     * Create a new date instance for yesterday.
     *
     * @param \DateTimeZone|string|null $tz
     * @param int                       $adjustment
     *
     * @return static
     */
    public static function yesterday($tz = null, int $adjustment = 0)
    {
        return static::today($tz, $adjustment)->subDay();
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
     * Resets the time to 00:00:00
     *
     * @return static
     */
    public function startOfDay()
    {
        $this->date->setTime(0, 0, 0);

        return $this;
    }

    /**
     * Add or remove days from instance.
     *
     * @param int $value
     *
     * @return static
     */
    public function addDays($value)
    {
        $this->date->addDays($value);

        return $this->recalculate();
    }

    /**
     * Add a day to the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function addDay($value = 1)
    {
        return $this->addDays($value);
    }

    /**
     * Remove a day from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subDay($value = 1)
    {
        return $this->subDays($value);
    }

    /**
     * Remove days from the instance
     *
     * @param int $value
     *
     * @return static
     */
    public function subDays($value)
    {
        return $this->addDays(-1 * $value);
    }

    /**
     * Set the instance's timezone from a string or object
     *
     * @param \DateTimeZone|string $value
     *
     * @return $this
     */
    public function setTimezone($value)
    {
        $this->date->setTimezone($value);

        return $this;
    }

    /**
     * Sets the current time to a different time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     *
     * @return static
     */

    public function setTime($hour, $minute, $second = 0)
    {
        $this->date->setTime($hour, $minute, $second);

        return $this;
    }

    /**
     * get date string
     *
     * @param string $format
     * @param int    $numbers
     *
     * @return string
     */
    public function format(string $format = 'l j M o', int $numbers = 0)
    {
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
        $julian = Converter::gregorianToJulian($this->date->year, $this->date->month, $this->date->day);
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
     * @return $this
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

        foreach ($this->formats as $format)
        {
            $this->values[$format] = $this->date->format($format);
        }

        return $this;
    }

    /**
     * @param $attribute
     *
     * @return mixed
     */
    public function __get($attribute)
    {
        switch ($attribute)
        {
            case 'adjustment':
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
}