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

namespace Calendar;

class Calendar_Cell_Year extends \Calendar_Cell implements \Iterator
{
	protected $_offset = 0;

	public static function forge($year = null, $calendar_name = 'default')
	{
		return new static($year, $calendar_name);
	}

	public function __construct($year = null, $calendar_name = 'default')
	{

		$this->_calendar_name = $calendar_name;

		is_null($year) and $year = (int) date('Y');
		
		$time = mktime(0, 0, 0, 1, 1, $year);

		$this->_params = array(
			'year'	=> $year,
			'month'	=> 1,
			'week'	=> 1,
			'day'	=> 1,
			'time'	=> $time,
		);
	}

	public function get_months()
	{
		$months = array();

		for ($month = 1; $month <= 12; $month++)
		{
			$months[] = $this->get_calendar()->get_month($month, $this->year);
		}

		return $months;
	}

	public function current()
	{
		return $this->get_calendar()->get_day($this->day + $this->_offset, $this->month, $this->year);
	}

	public function key()
	{
		return $this->_offset;
	}

	public function next()
	{
		$this->_offset++;
	}

	public function rewind()
	{
		$this->_offset = 0;
	}

	public function valid()
	{
		return $this->year == date('Y', mktime(0, 0, 0, $this->month, $this->day + $this->_offset, $this->year));
	}
}