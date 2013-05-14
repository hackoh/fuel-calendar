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
class Test_Calendar_Cell_Year extends TestCase
{
	public function setUp()
	{
		Package::load('calendar');
	}

	public function test_forge()
	{
		$year = \Calendar_Cell_Year::forge();

		$expected = true;

		$this->assertEquals($expected, $year instanceof \Calendar_Cell_Year);

		$expected = (int) date('Y');

		$this->assertEquals($expected, $year->year);
	}

	public function test_get_calendar()
	{
		$year = \Calendar_Cell_Year::forge();

		$expected = 'default';

		$this->assertEquals($expected, $year->get_calendar()->get_name());

		$year->set_calendar_name(null);

		try
		{
			$calendar = $year->get_calendar();
		}
		catch (\OutOfBoundsException $e)
		{
			return;
		}

		$this->fail('Exception expected did not occur.');
	}

	public function test_get_month()
	{
		$year = \Calendar_Cell_Year::forge();

		$expected = 5;

		$this->assertEquals(true, $year->get_month(5) instanceof \Calendar_Cell_Month);
		$this->assertEquals(5, $year->get_month(5)->month);

		$expected = (int) date('n');

		$this->assertEquals(true, $year->get_month() instanceof \Calendar_Cell_Month);
		$this->assertEquals($expected, $year->get_month()->month);
	}

	public function test_get_months()
	{
		$year = \Calendar_Cell_Year::forge();

		$count = 0;

		foreach ($year->get_months() as $month)
		{
			++$count;
			$this->assertEquals($count, $month->month);
			$this->assertEquals(true, $month instanceof \Calendar_Cell_Month);
		}

		$expected = 12;
		$this->assertEquals($expected, $count);
	}

	public function test_foreach()
	{
		$year = \Calendar_Cell_Year::forge(2013);

		$count = 0;

		foreach ($year as $day)
		{
			++$count;
			$this->assertEquals(true, $day instanceof \Calendar_Cell_Day);
		}

		$expected = 365;
		$this->assertEquals($expected, $count);
	}

	public function test_foreach_leap()
	{
		$year = \Calendar_Cell_Year::forge(2012);

		$count = 0;

		foreach ($year as $day)
		{
			++$count;
			$this->assertEquals(true, $day instanceof \Calendar_Cell_Day);
		}

		$expected = 366;
		$this->assertEquals($expected, $count);
	}
}