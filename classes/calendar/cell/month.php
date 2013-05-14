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
 * 
 */
class Calendar_Cell_Month extends \Calendar_Cell implements \Iterator
{
	/**
	 * [$_offset description]
	 * @var integer
	 */
	protected $_offset = 0;

	/**
	 * [forge description]
	 * @param  [type] $month [description]
	 * @param  [type] $year  [description]
	 * @return [type]        [description]
	 */
	public static function forge($month = null, $year = null)
	{
		return new static($month, $year);
	}

	/**
	 * [__construct description]
	 * @param [type] $month [description]
	 * @param [type] $year  [description]
	 */
	public function __construct($month = null, $year = null)
	{
		is_null($month) and $month = (int) date('n');
		is_null($year) and $year = (int) date('Y');
		
		$time = mktime(0, 0, 0, $month, 1, $year);

		$this->_params = array(
			'year'	=> $year,
			'month'	=> $month,
			'time'	=> $time,
		);
	}

	/**
	 * [get_weeks description]
	 * @return [type] [description]
	 */
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

	/**
	 * [get_day description]
	 * @param  [type] $day [description]
	 * @return [type]      [description]
	 */
	public function get_day($day = null)
	{
		return $this->get_calendar()->get_day($day, $this->month, $this->year);	
	}

	/**
	 * [current description]
	 * @return [type] [description]
	 */
	public function current()
	{
		return $this->get_calendar()->get_day(1 + $this->_offset, $this->month, $this->year);
	}

	/**
	 * [key description]
	 * @return [type] [description]
	 */
	public function key()
	{
		return $this->_offset;
	}

	/**
	 * [next description]
	 * @return function [description]
	 */
	public function next()
	{
		$this->_offset++;
	}

	/**
	 * [rewind description]
	 * @return [type] [description]
	 */
	public function rewind()
	{
		$this->_offset = 0;
	}

	/**
	 * [valid description]
	 * @return [type] [description]
	 */
	public function valid()
	{
		return (1 + $this->_offset) <= cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
	}
}