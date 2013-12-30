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
class Test_Calendar_Cell_Week extends TestCase
{
	public function setUp()
	{
		Package::load('calendar');
	}

	public function test_forge()
	{
		$week = \Calendar_Cell_Week::forge();

		$expected = true;

		$this->assertEquals($expected, $week instanceof \Calendar_Cell_Week);

		$expected = (int) date('j');
		$wday = (int) date('w');
		while ($wday)
		{
			$expected = (int) date('j', mktime(0, 0, 0, (int) date('n'), --$expected));
			--$wday;
		}

		$this->assertEquals($expected, $week->get_day(0)->day);
	}

	public function test_get_calendar()
	{
		$week = \Calendar_Cell_Week::forge();

		$expected = 'default';

		$this->assertEquals($expected, $week->get_calendar()->get_name());

		$week->set_calendar_name(null);

		try
		{
			$calendar = $week->get_calendar();
		}
		catch (\OutOfBoundsException $e)
		{
			return;
		}

		$this->fail('Exception expected did not occur.');
	}

	public function test_get_day()
	{
		$week = \Calendar_Cell_Week::forge();

		$expected = 0;

		$this->assertEquals(true, $week->get_day(0) instanceof \Calendar_Cell_Day);
		$this->assertEquals($expected, (int) $week->get_day(0)->format('w'));
	}

	public function test_foreach()
	{
		$week = \Calendar_Cell_Week::forge(1, 5, 2013);

		$count = 0;

		foreach ($week as $day)
		{
			++$count;
			$this->assertEquals(true, $day instanceof \Calendar_Cell_Day);
		}

		$expected = $week->get_calendar()->get_config('valid') + 1;
		$this->assertEquals($expected, $count);
	}
}