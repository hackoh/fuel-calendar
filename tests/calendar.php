<?php
/**
 * Calendar
 *
 * The Package of calendar.
 *
 * @package    Calendar
 * @version    1.0
 * @author     hackoh
 * @license    MIT License
 * @link       http://github.com/hackoh
 */

namespace Fuel\Core;

/**
 * Calendar class tests
 *
 * @group Calendar
 */
class Test_Calendar extends TestCase
{
	public function setUp()
	{
		Package::load('calendar');
	}

	public function test_forge()
	{
		try
		{
			$calendar = \Calendar::forge('test');
		}
		catch (\DomainException $e)
		{}

		$expected = true;

		$this->assertEquals($expected, $calendar instanceof \Calendar);
	}

	public function test_forge_recreated()
	{
		\Calendar::forge('test_forge_recreated');
		
		$is_error = false;
		try
		{
			$calendar = \Calendar::forge('test_forge_recreated');
		}
		catch (\DomainException $e)
		{
			$is_error = true;
		}

		$expected = true;

		$this->assertEquals($expected, $is_error);
	}

	public function test_day_data_handling()
	{
		$day = \Calendar::day(-1, 0, 2013);

		$expected = '2012/11/29';

		$this->assertEquals($expected, $day->format('Y/m/d'));

		$day->set_data('This is test data');

		$day = \Calendar::day(29, 11, 2012);

		$expected = 'This is test data';

		$this->assertEquals($expected, $day->get_data());
	}

	public function test_week_data_handling()
	{
		$week = \Calendar::week(1, 0, 2013);

		$expected = '2012/11';

		$this->assertEquals($expected, $week->format('Y/m'));

		$week->set_data('This is test data');

		$week = \Calendar::week(5, 11, 2012);

		$expected = 'This is test data';

		$this->assertEquals($expected, $week->get_data());
	}

	public function test_instance()
	{
		$calendar = \Calendar::instance('default');

		$expected = true;

		$this->assertEquals($expected, $calendar instanceof \Calendar);
	}

	public function test_instance_default()
	{
		$calendar = \Calendar::instance();

		$expected = 'default';

		$this->assertEquals($expected, $calendar->get_name());
	}

	public function test_instance_false()
	{
		$is_error = false;
		try
		{
			$calendar = \Calendar::instance('foo');
		}
		catch (\OutOfBoundsException $e)
		{
			$is_error = true;
		}

		$expected = true;

		$this->assertEquals($expected, $is_error);
	}

	public function test_get_year()
	{
		$calendar = \Calendar::forge('test_get_year');

		$expected = 2013;

		$this->assertEquals(true, $calendar->get_year(2013) instanceof \Calendar_Cell_Year);
		$this->assertEquals($expected, $calendar->get_year(2013)->year);

		$expected = (int) date('Y');

		$this->assertEquals(true, $calendar->get_year() instanceof \Calendar_Cell_Year);
		$this->assertEquals($expected, $calendar->get_year()->year);
	}

	public function test_year()
	{
		$calendar = \Calendar::forge('test_year');

		$this->assertEquals(true, $calendar->get_year() === \Calendar::year(null, 'test_year'));

		$this->assertEquals(false, $calendar->get_year() === \Calendar::year());
	}

	public function test_get_month()
	{
		$calendar = \Calendar::forge('test_get_month');

		$expected = '2013/05';

		$this->assertEquals(true, $calendar->get_month(5, 2013) instanceof \Calendar_Cell_Month);
		$this->assertEquals($expected, $calendar->get_month(5, 2013)->format('Y/m'));

		$expected = date('Y/m');

		$this->assertEquals(true, $calendar->get_month() instanceof \Calendar_Cell_Month);
		$this->assertEquals($expected, $calendar->get_month()->format('Y/m'));
	}

	public function test_month()
	{
		$calendar = \Calendar::forge('test_month');

		$this->assertEquals(true, $calendar->get_month() === \Calendar::month(null, null, 'test_month'));

		$this->assertEquals(false, $calendar->get_month() === \Calendar::month());
	}

	public function test_get_week()
	{
		$calendar = \Calendar::forge('test_get_week');

		$expected = '2013/04/28';

		$this->assertEquals(true, $calendar->get_week(1, 5, 2013) instanceof \Calendar_Cell_Week);
		$this->assertEquals($expected, $calendar->get_week(1, 5, 2013)->format('Y/m/d'));
	}

	public function test_week()
	{
		$calendar = \Calendar::forge('test_week');

		$this->assertEquals(true, $calendar->get_week() === \Calendar::week(null, null, null, 'test_week'));

		$this->assertEquals(false, $calendar->get_week() === \Calendar::week());
	}

	public function test_get_day()
	{
		$calendar = \Calendar::forge('test_get_day');

		$expected = '2013/05/09';

		$this->assertEquals(true, $calendar->get_day(9, 5, 2013) instanceof \Calendar_Cell_Day);
		$this->assertEquals($expected, $calendar->get_day(9, 5, 2013)->format('Y/m/d'));
	}

	public function test_day()
	{
		$calendar = \Calendar::forge('test_day');

		$this->assertEquals(true, $calendar->get_day() === \Calendar::day(null, null, null, 'test_day'));

		$this->assertEquals(false, $calendar->get_day() === \Calendar::day());
	}

	public function test_get_holidays()
	{
		$calendar = \Calendar::forge('test_get_holidays');

		$calendar->set_config('holidays.2013.5.9', 'My birthday!');

		$holidays = $calendar->get_holidays();

		$expected = 'My birthday!';

		$this->assertEquals($expected, \Arr::get($holidays, '2013.5.9'));

		$holidays = $calendar->get_holidays('/');

		$expected = '2013/5/9';

		$keys = array_keys($holidays);

		$this->assertEquals($expected, current($keys));
	}

	public function test_config()
	{

		\Calendar::forge('foo', array(
			'holidays' => array(
				2013 => array(
					5 => array(
						9 => 'Foo'
					)
				)
			)
		));

		$holidays = \Calendar::holidays(false, 'foo');

		$expected = 'Foo';

		$this->assertEquals($expected, \Arr::get($holidays, '2013.5.9'));

		\Calendar::instance()->set_config('holidays.2013.5.9', 'Holiday');

		$holidays = \Calendar::holidays();

		$expected = 'Holiday';

		$this->assertEquals($expected, \Arr::get($holidays, '2013.5.9'));

		\Calendar::instance()->set_config('holidays.2013.5', array());

		$holidays = \Calendar::holidays();

		$expected = null;

		$this->assertEquals($expected, \Arr::get($holidays, '2013.5.9'));
	}

	public function test_month_start_or_end_is_sunday()
	{
		$calendar = \Calendar::month(6, 2014);
		$day_count = 0;
		foreach ($calendar->get_weeks() as $week)
		{
			foreach ($week as $day)
			{
				$day_count++;
			}
		}

		$expected = 35;
		$this->assertEquals($expected, $day_count);

		$calendar = \Calendar::month(8, 2014);
		$day_count = 0;
		foreach ($calendar->get_weeks() as $week)
		{
			foreach ($week as $day)
			{
				$day_count++;
			}
		}

		$expected = 42;
		$this->assertEquals($expected, $day_count);
	}
}