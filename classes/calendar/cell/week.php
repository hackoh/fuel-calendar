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

class Calendar_Cell_Week extends \Calendar_Cell implements \Iterator
{
	protected $_offset = 0;

	public static function forge($week = null, $month = null, $year = null, $calendar_name = 'default')
	{
		return new static($week, $month, $year, $calendar_name);
	}

	public function __construct($week = null, $month = null, $year = null, $calendar_name = 'default')
	{

		$this->_calendar_name = $calendar_name;

		is_null($month) and $month = (int) date('n');
		is_null($year) and $year = (int) date('Y');
		is_null($week) and $week = (int) date('W', mktime(0, 0, 0, $month, (int) date('j'), $year)) - (int) date('W', mktime(0, 0, 0, $month, 1, $year)) + 1;

		for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $month, $year); $day++)
		{
			$w = date('W', mktime(0, 0, 0, $month, $day, $year)) - date('W', mktime(0, 0, 0, $month, 1, $year)) + 1;
			if ($week == $w) break;
		}

		if ($day === 1)
		{
			for (;; $day--)
			{
				if (date('w', mktime(0, 0, 0, $month, $day, $year)) == 0)
				{
					break;
				}
			}
		}
		else
		{
			$day -= 1;
		}
		

		$time = mktime(0, 0, 0, $month, $day, $year);

		$this->_params = array(
			'year'	=> $year,
			'month'	=> $month,
			'week'	=> $week,
			'day'	=> $day,
			'time'	=> $time,
		);
	}

	public function get_day($wday)
	{
		return $this->get_calendar()->get_day($this->day + $wday, $this->month, $this->year);	
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
		return $this->_offset <= 6;
	}
}