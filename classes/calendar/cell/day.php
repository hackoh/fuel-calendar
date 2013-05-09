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

class Calendar_Cell_Day extends \Calendar_Cell
{

	public static function forge($day = null, $month = null, $year = null, $calender_name = 'default')
	{
		return new static($day, $month, $year, $calender_name);
	}

	public function __construct($day = null, $month = null, $year = null, $calender_name = 'default')
	{

		$this->_calender_name = $calender_name;

		is_null($day) and $day = (int) date('j');
		is_null($month) and $month = (int) date('n');
		is_null($year) and $year = (int) date('Y');
		$week = (int) date('W', mktime(0, 0, 0, $month, $day, $year)) - (int) date('W', mktime(0, 0, 0, $month, 1, $year)) + 1;

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