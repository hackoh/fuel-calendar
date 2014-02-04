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

/**
 * The Calendar_Cell_Week class is one of concrete class of Calendar_Cell.
 * This object has five read-only params. "year", "month", "week", "day" and "time".
 * And If you use as array by foreach, It splits Calendar_Cell_Day instances.
 */
class Calendar_Cell_Week extends Calendar_Cell implements \Iterator
{
	/**
	 * Create Calendar_Cell_Week object.
	 * 
	 * @param  int $week 
	 * @param  int $month
	 * @param  int $year
	 * @return Calendar_Cell_Week
	 */
	public static function forge($week = null, $month = null, $year = null)
	{
		return new static($week, $month, $year);
	}

	/**
	 * the offset for foreach
	 * @var int
	 */
	protected $_offset = 0;

	/**
	 * Object constructor
	 * 
	 * @param  int $week 
	 * @param  int $month
	 * @param  int $year
	 */
	public function __construct($week = null, $month = null, $year = null)
	{
		is_null($month) and $month = (int) date('n');
		is_null($year) and $year = (int) date('Y');
		is_null($week) and $week = (int) date('W', mktime(0, 0, 0, $month, (int) date('j'), $year)) - (int) date('W', mktime(0, 0, 0, $month, 1, $year)) + 1;

		for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $month, $year); $day++)
		{
			$w = date('W', mktime(0, 0, 0, $month, $day, $year)) - date('W', mktime(0, 0, 0, $month, 1, $year)) + 1;
			if ($week == $w)
			{
				break;
			}
		}

		if ($day === 1)
		{
			while (true)
			{
				if (date('w', mktime(0, 0, 0, $month, $day, $year)) == 0)
				{
					break;
				}
				$day--;
			}
		}
		else
		{
			$day -= 1;
		}
		
		// The "time" is {YEAR}/{MONTH}/{DAY} 00:00:00.
		// It does not necessarily become this month.
		$time = mktime(0, 0, 0, $month, $day, $year);

		$this->_params = array(
			'year'	=> $year,
			'month'	=> $month,
			'week'	=> $week,
			'day'	=> $day,
			'time'	=> $time,
		);
	}

	/**
	 * Return the specific Calendar_Cell_Day instance
	 * 
	 * @param  int $wday   the week day. 0 is sunday and 6 is saturday.
	 * @return Calendar_Cell_Day
	 */
	public function get_day($wday)
	{
		return $this->get_calendar()->get_day($this->day + $wday, $this->month, $this->year);	
	}

	/**
	 * Return the current Calendar_Cell_Day instance
	 * 
	 * @return Calendar_Cell_Day
	 */
	public function current()
	{
		return $this->get_calendar()->get_day($this->day + (int) $this->_offset, $this->month, $this->year);
	}

	/**
	 * Return the current offset
	 *  
	 * @return int
	 */
	public function key()
	{
		return (int) $this->_offset;
	}

	/**
	 * @return void
	 */
	public function next()
	{
		$this->_offset++;
	}

	/**
	 * @return void
	 */
	public function rewind()
	{
		$this->_offset = (string) $this->get_calendar()->get_config('start_of_the_week');
	}

	/**
	 * Validate the current offset
	 * @return boolean
	 */
	public function valid()
	{
		$end = $this->get_calendar()->get_config('start_of_the_week');

		$this->_offset <= 6 || $this->_offset = 0;

		return is_string($this->_offset) || $end !== $this->_offset;
	}
}