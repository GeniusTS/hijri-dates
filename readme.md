# Hijri date

a PHP library to convert Gregorian date to Hijri date and vice versa.

It's based on [nesbot/carbon](https://github.com/briannesbitt/Carbon) package.

## Installation

```bash
	composer require geniusts/hijri-dates
```

## Usage

* you can immediatly get the hijri date with `Date` class function.


```php
	$now = \GeniusTS\HijriDate\Date::now();
	$today = \GeniusTS\HijriDate\Date::today();
	$tomorrow = \GeniusTS\HijriDate\Date::tomorrow();
	$yesterday = \GeniusTS\HijriDate\Date::yesterday();
```

* to convert from Gregorian date to Hijri Date.

```php
	$date = \GeniusTS\HijriDate\Hijri::convertToHijri('2017-05-05');
```

* to convert from Hijri date to Gregorian Date.

```php
	// This function return a Carbon instance.
	$date = \GeniusTS\HijriDate\Hijri::convertToGregorian(8, 8, 1438);
```

* get date formated string.

```php
	use GeniusTS\HijriDate\Date;

	$today = Date::today();

	// use the second parameter to return indian numbers
	echo $today->format('l d F o', Date::INDIAN_NUMBERS);
```

## Configurations

* Changing the adjustment days.

```php
	\GeniusTS\HijriDate\Hijri::setDefaultAdjustment(1);
```

* Changing the translation language.

```php
	use GeniusTS\HijriDate\Translations\Arabic;

	\GeniusTS\HijriDate\Date::setTranslation(new Arabic);
```

* Changing the default toString format language.

```php
	\GeniusTS\HijriDate\Date::setToStringFormat('l d F o');
```

* Changing the default numeric system.

```php
	use GeniusTS\HijriDate\Date;

	Date::setDefaultNumbers(Date::INDIAN_NUMBERS);
```

----

There is some methods from `Carbon` class you can use it with `Date` class.

---

## License

This package is free software distributed under the terms of the MIT license.
