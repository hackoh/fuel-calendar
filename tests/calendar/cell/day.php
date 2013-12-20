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
class Test_Calendar_Cell_Day extends TestCase
{
	public function setUp()
	{
		Package::load('calendar');
	}

	public function test_forge()
	{
		$day = \Calendar_Cell_Day::forge();

		$expected = true;

		$this->assertEquals($expected, $day instanceof \Calendar_Cell_Day);

		$expected = (int) date('j');

		$this->assertEquals($expected, $day->day);
	}

	public function test_forge_minus()
	{
		$day = \Calendar_Cell_Day::forge(-1, 0, 2013);

		$expected = '2012/11/29';

		$this->assertEquals($expected, $day->format('Y/m/d'));

		$day->set_data('This is test data');

		$day = \Calendar_Cell_Day::forge(29, 11, 2012);

		$expected = null;

		$this->assertEquals($expected, $day->get_data());
	}

	public function test_get_calendar()
	{
		$day = \Calendar_Cell_Day::forge();

		$expected = 'default';

		$this->assertEquals($expected, $day->get_calendar()->get_name());

		$day->set_calendar_name(null);

		try
		{
			$calendar = $day->get_calendar();
		}
		catch (\OutOfBoundsException $e)
		{
			return;
		}

		$this->fail('Exception expected did not occur.');
	}

	public function test_is_holiday()
	{
		\Calendar::config('holidays.2013.5.9', 'My birthday!');
		$day = \Calendar_Cell_Day::forge(9, 5, 2013);

		$expected = true;

		$this->assertEquals($expected, $day->is_holiday());


		$day = \Calendar_Cell_Day::forge(8, 5, 2013);

		$expected = false;

		$this->assertEquals($expected, $day->is_holiday());
	}

	public function test_holiday()
	{
		\Calendar::config('holidays.2013.12.10', 'This is the birthday');
		$day = \Calendar_Cell_Day::forge(10, 12, 2013);

		$expected = 'This is the birthday';

		$this->assertEquals($expected, $day->holiday);
	}

	public function test_is_today()
	{
		$this_year = date('Y');
		$this_month = date('n');
		$this_day = date('j');

		$day = \Calendar_Cell_Day::forge($this_day, $this_month, $this_year);
		$expected = true;
		$this->assertEquals($expected, $day->is_today());

		$day = \Calendar_Cell_Day::forge($this_day - 1, $this_month - 1, $this_year - 1);
		$expected = false;
		$this->assertEquals($expected, $day->is_today());
	}
}