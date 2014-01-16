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
 * The Calendar_Cell_Month class is one of concrete class of Calendar_Cell.
 * This object has three read-only params. "year", "month" and "time".
 * This object can return Calendar_Cell_Week instance(s).
 * And If you use as array by foreach, It splits Calendar_Cell_Day instances.
 */
class Calendar_Cell_Month extends Calendar_Cell implements \Iterator
{
	/**
	 * Create Calendar_Cell_Month object.
	 * 
	 * @param  int $month
	 * @param  int $year
	 * @return Calendar_Cell_Month
	 */
	public static function forge($month = null, $year = null)
	{
		return new static($month, $year);
	}

	/**
	 * the offset for foreach
	 * @var int
	 */
	protected $_offset = 0;

	/**
	 * Object constructor
	 * 
	 * @param  int $month
	 * @param  int $year
	 */
	public function __construct($month = null, $year = null)
	{
		is_null($month) and $month = (int) date('n');
		is_null($year) and $year = (int) date('Y');
		
		// The "time" is {YEAR}/{MONTH}/01 00:00:00.
		$time = mktime(0, 0, 0, $month, 1, $year);

		$this->_params = array(
			'year'	=> $year,
			'month'	=> $month,
			'time'	=> $time,
		);
	}

	/**
	 * Return the array of all Calendar_Cell_Week instance of this month
	 * @return array   an array contains Calendar_Cell_Week instances
	 */
	public function get_weeks()
	{
		$weeks = array();
		for ($day = 1; $this->month == date('n', mktime(0, 0, 0, $this->month, $day, $this->year)); $day++)
		{
			$week = (int) date('W', mktime(0, 0, 0, $this->month, $day, $this->year)) - (int) date('W', mktime(0, 0, 0, $this->month, 1, $this->year)) + 1;
			if ( ! in_array($week, $weeks)) $weeks[] = $week;
		}

		$day--;
		if ((int) date('w', mktime(0, 0, 0, $this->month, $day, $this->year)) === 0)
		{
			$weeks[] = $week + 1;
		}

		foreach ($weeks as $index => $week)
		{
			$weeks[$index] = $this->get_calendar()->get_week($week, $this->month, $this->year);
		}

		return $weeks;
	}

	/**
	 * Return the specific Calendar_Cell_Day instance
	 * 
	 * @param  int $day
	 * @return Calendar_Cell_Day
	 */
	public function get_day($day = null)
	{
		return $this->get_calendar()->get_day($day, $this->month, $this->year);	
	}

	/**
	 * Return the current Calendar_Cell_Day instance
	 * 
	 * @return Calendar_Cell_Day
	 */
	public function current()
	{
		return $this->get_calendar()->get_day(1 + $this->_offset, $this->month, $this->year);
	}

	/**
	 * Return the current offset
	 *  
	 * @return int
	 */
	public function key()
	{
		return $this->_offset;
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
		$this->_offset = 0;
	}

	/**
	 * Validate the current offset
	 * @return boolean
	 */
	public function valid()
	{
		return (1 + $this->_offset) <= cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
	}
}