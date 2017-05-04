<?php

namespace GeniusTS\HijriDate\Translations;


/**
 * Interface TranslationInterface
 *
 * @package GeniusTS\HijriDate\Translations
 */
interface TranslationInterface
{

    /**
     * get array of months names
     *
     * @return array
     */
    public function getHijriMonths(): array;

    /**
     * get array of short days names
     * started from Sunday
     *
     * @return array
     */
    public function getShortDays(): array;

    /**
     * get array of months names
     * started from Sunday
     *
     * @return array
     */
    public function getDays(): array;

    /**
     * get array of periods
     *
     * @return array
     */
    public function getPeriods(): array;

}