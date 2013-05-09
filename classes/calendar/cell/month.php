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

class Calendar_Cell_Month extends \Calendar_Cell implements \Iterator
{
	protected $_offset = 0;

	public static function forge($month = null, $year = null, $calendar_name = 'default')
	{
		return new static($month, $year, $calendar_name);
	}

	public function __construct($month = null, $year = null, $calendar_name = 'default')
	{

		$this->_calendar_name = $calendar_name;

		is_null($month) and $month = (int) date('n');
		is_null($year) and $year = (int) date('Y');
		
		$time = mktime(0, 0, 0, $month, 1, $year);

		$this->_params = array(
			'year'	=> $year,
			'month'	=> $month,
			'week'	=> 1,
			'day'	=> 1,
			'time'	=> $time,
		);
	}

	public function get_weeks()
	{
		$weeks = array();
		for ($day = 1; $this->month == date('n', mktime(0, 0, 0, $this->month, $day, $this->year)); $day++)
		{
			$week = (int) date('W', mktime(0, 0, 0, $this->month, $day, $this->year)) - (int) date('W', mktime(0, 0, 0, $this->month, 1, $this->year)) + 1;
			if ( ! in_array($week, $weeks)) $weeks[] = $week;
		}

		foreach ($weeks as $index => $week)
		{
			$weeks[$index] = $this->get_calendar()->get_week($week, $this->month, $this->year);
		}

		return $weeks;
	}

	public function get_day($day)
	{
		return $this->get_calendar()->get_day($day, $this->month, $this->year);	
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
		return ($this->day + $this->_offset) <= cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
	}
}