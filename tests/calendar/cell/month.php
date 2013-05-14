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
class Test_Calendar_Cell_Month extends TestCase
{
	public function setUp()
	{
		Package::load('calendar');
	}

	public function test_forge()
	{
		$month = \Calendar_Cell_Month::forge();

		$expected = true;

		$this->assertEquals($expected, $month instanceof \Calendar_Cell_Month);

		$expected = (int) date('n');

		$this->assertEquals($expected, $month->month);
	}

	public function test_get_calendar()
	{
		$month = \Calendar_Cell_Month::forge();

		$expected = 'default';

		$this->assertEquals($expected, $month->get_calendar()->get_name());

		$month->set_calendar_name(null);

		try
		{
			$calendar = $month->get_calendar();
		}
		catch (\OutOfBoundsException $e)
		{
			return;
		}

		$this->fail('Exception expected did not occur.');
	}

	public function test_get_day()
	{
		$month = \Calendar_Cell_Month::forge();

		$expected = 5;

		$this->assertEquals(true, $month->get_day(5) instanceof \Calendar_Cell_Day);
		$this->assertEquals($expected, $month->get_day(5)->day);

		$expected = (int) date('j');

		$this->assertEquals(true, $month->get_day() instanceof \Calendar_Cell_Day);
		$this->assertEquals($expected, $month->get_day()->day);
	}

	public function test_get_weeks()
	{
		$month = \Calendar_Cell_Month::forge(5, 2013);

		$count = 0;

		foreach ($month->get_weeks() as $week)
		{
			++$count;
			$this->assertEquals(true, $week instanceof \Calendar_Cell_Week);
		}

		$expected = 5;
		$this->assertEquals($expected, $count);
	}

	public function test_foreach()
	{
		$month = \Calendar_Cell_Month::forge(5, 2013);

		$count = 0;

		foreach ($month as $day)
		{
			++$count;
			$this->assertEquals(true, $day instanceof \Calendar_Cell_Day);
		}

		$expected = 31;
		$this->assertEquals($expected, $count);
	}
}