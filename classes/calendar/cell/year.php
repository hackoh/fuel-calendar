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
class Calendar_Cell_Year extends \Calendar_Cell implements \Iterator
{
	/**
	 * [$_offset description]
	 * @var integer
	 */
	protected $_offset = 0;

	/**
	 * [forge description]
	 * @param  [type] $year          [description]
	 * @param  string $calendar_name [description]
	 * @return [type]                [description]
	 */
	public static function forge($year = null)
	{
		return new static($year);
	}

	/**
	 * [__construct description]
	 * @param [type] $year          [description]
	 * @param string $calendar_name [description]
	 */
	public function __construct($year = null)
	{
		is_null($year) and $year = (int) date('Y');
		
		$time = mktime(0, 0, 0, 1, 1, $year);

		$this->_params = array(
			'year'	=> $year,
			'time'	=> $time,
		);
	}

	/**
	 * [get_month description]
	 * @param  [type] $month [description]
	 * @return [type]        [description]
	 */
	public function get_month($month = null)
	{
		return $this->get_calendar()->get_month($month, $this->year);
	}

	/**
	 * [get_months description]
	 * @return [type] [description]
	 */
	public function get_months()
	{
		$months = array();

		for ($month = 1; $month <= 12; $month++)
		{
			$months[] = $this->get_calendar()->get_month($month, $this->year);
		}

		return $months;
	}

	/**
	 * [current description]
	 * @return [type] [description]
	 */
	public function current()
	{
		return $this->get_calendar()->get_day(1 + $this->_offset, 1, $this->year);
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
		return $this->year == date('Y', mktime(0, 0, 0, 1, 1 + $this->_offset, $this->year));
	}
}