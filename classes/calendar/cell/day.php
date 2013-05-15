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
 * The Calendar_Cell_Day class is one of concrete class of Calendar_Cell.
 * This object has six read-only params. "year", "month", "week", "day", "time" and "holiday".
 * This class does not implement Iterator interface.
 * Because this class is smallest of Calendar_Cell.
 */
class Calendar_Cell_Day extends Calendar_Cell
{
	/**
	 * Create Calendar_Cell_Day object.
	 * 
	 * @param  int $day 
	 * @param  int $month
	 * @param  int $year
	 * @return Calendar_Cell_Week
	 */
	public static function forge($day = null, $month = null, $year = null)
	{
		return new static($day, $month, $year);
	}

	/**
	 * Object constructor
	 * 
	 * @param  int $day 
	 * @param  int $month
	 * @param  int $year
	 */
	public function __construct($day = null, $month = null, $year = null)
	{
		is_null($day) and $day = (int) date('j');
		is_null($month) and $month = (int) date('n');
		is_null($year) and $year = (int) date('Y');
		
		$week = (int) date('W', mktime(0, 0, 0, $month, $day, $year)) - (int) date('W', mktime(0, 0, 0, $month, 1, $year)) + 1;

		// The "time" is {YEAR}/{MONTH}/{DAY} 00:00:00.
		$time = mktime(0, 0, 0, $month, $day, $year);

		$this->_params = array(
			'year'		=> (int) date('Y', $time),
			'month'		=> (int) date('n', $time),
			'week'		=> $week,
			'day'		=> (int) date('j', $time),
			'time'		=> $time,
			'holiday'	=> $this->get_calendar()->get_config('holidays.'.implode('.', array($year, $month, $day))),
		);
	}

	/**
	 * Return the boolean value of whether this day is a holiday or not.
	 * 
	 * @param  boolean $saturday_flag  If false given, then return FALSE when saturday.
	 * @return boolean
	 */
	public function is_holiday($saturday_flag = true)
	{
		$wday = date('w', $this->time);

		switch (true)
		{
			case $saturday_flag && $wday == 6:
			case $wday == 0:
			case $this->holiday ? true : false:
				return true;
		}

		return false;
	}
}