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

	public function test_instance()
	{
		$calendar = \Calendar::instance();

		$expected = 'default';

		$this->assertEquals($expected, $calendar->get_name());
	}

	public function test_year()
	{
		$expected = 2013;

		$this->assertEquals($expected, \Calendar::year(2013)->year);
	}

	public function test_year_months()
	{

		$expected = 12;

		$this->assertEquals($expected, count(\Calendar::year(2013)->get_months()));
	}

	public function test_month()
	{
		$month = \Calendar::month(5, 2013);

		$expected = 5;

		$this->assertEquals($expected, $month->month);
	}

	public function test_month_data()
	{
		$month = \Calendar::month(5, 2013);

		$expected = 5;

		$month->set_data('foo');

		$month = \Calendar::month(5, 2013);

		$this->assertEquals('foo', $month->get_data());
	}

	public function test_month_weeks()
	{
		$weeks = \Calendar::month(5, 2013)->get_weeks();

		$expected = 5;

		$this->assertEquals($expected, count($weeks));
	}

	public function test_month_day()
	{
		$day = \Calendar::month(5, 2013)->get_day(9);

		$expected = 9;

		$this->assertEquals($expected, $day->day);

		$expected = '誕生日';

		$this->assertEquals($expected, $day->holiday);

		$expected = true;

		$this->assertEquals($expected, $day->is_holiday());
	}

	public function test_render_calendar()
	{
		$month = \Calendar::month(5, 2013);

		$expected = array(
			array('0428', '0429', '0430', '0501', '0502', '0503', '0504'),
			array('0505', '0506', '0507', '0508', '0509', '0510', '0511'),
			array('0512', '0513', '0514', '0515', '0516', '0517', '0518'),
			array('0519', '0520', '0521', '0522', '0523', '0524', '0525'),
			array('0526', '0527', '0528', '0529', '0530', '0531', '0601'),
		);

		foreach ($month->get_weeks() as $week_offset => $week)
		{
			foreach ($week as $day_offset => $day)
			{
				$this->assertEquals($expected[$week_offset][$day_offset], $day->format('md'));
			}
		}
	}

	public function test_holidays()
	{

		$holidays = \Calendar::holidays();

		$expected = '誕生日';

		$this->assertEquals($expected, \Arr::get($holidays, '2013.5.9'));

		$holidays = \Calendar::holidays('/');

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

		$holidays = \Calendar::holidays();

		$expected = '誕生日';

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
}
