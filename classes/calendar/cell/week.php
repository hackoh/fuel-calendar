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
class Calendar_Cell_Week extends \Calendar_Cell implements \Iterator
{
	/**
	 * [$_offset description]
	 * @var integer
	 */
	protected $_offset = 0;

	/**
	 * [forge description]
	 * @param  [type] $week  [description]
	 * @param  [type] $month [description]
	 * @param  [type] $year  [description]
	 * @return [type]        [description]
	 */
	public static function forge($week = null, $month = null, $year = null)
	{
		return new static($week, $month, $year);
	}

	/**
	 * [__construct description]
	 * @param [type] $week  [description]
	 * @param [type] $month [description]
	 * @param [type] $year  [description]
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
	 * [get_day description]
	 * @param  [type] $wday [description]
	 * @return [type]       [description]
	 */
	public function get_day($wday)
	{
		return $this->get_calendar()->get_day($this->day + $wday, $this->month, $this->year);	
	}

	/**
	 * [current description]
	 * @return [type] [description]
	 */
	public function current()
	{
		return $this->get_calendar()->get_day($this->day + $this->_offset, $this->month, $this->year);
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
		return $this->_offset <= 6;
	}
}