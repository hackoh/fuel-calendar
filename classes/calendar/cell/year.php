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
 * The Calendar_Cell_Year class is one of concrete class of Calendar_Cell.
 * This object has only two read-only params. "year" and "time".
 * This object can return Calendar_Cell_Month instance(s).
 * And If you use as array by foreach, It splits Calendar_Cell_Day instances.
 */
class Calendar_Cell_Year extends Calendar_Cell implements \Iterator
{
	/**
	 * Create Calendar_Cell_Year object.
	 * 
	 * @param  int $year
	 * @return Calendar_Cell_Year
	 */
	public static function forge($year = null)
	{
		return new static($year);
	}

	/**
	 * the offset for foreach
	 * @var int
	 */
	protected $_offset = 0;

	/**
	 * Object constructor
	 * 
	 * @param int $year
	 */
	public function __construct($year = null)
	{
		is_null($year) and $year = (int) date('Y');

		// The "time" is {YEAR}/01/01 00:00:00.
		$time = mktime(0, 0, 0, 1, 1, $year);

		$this->_params = array(
			'year'	=> $year,
			'time'	=> $time,
		);
	}

	/**
	 * Return the specific Calendar_Cell_Month instance
	 * 
	 * @param  int $month
	 * @return Calendar_Cell_Month
	 */
	public function get_month($month = null)
	{
		return $this->get_calendar()->get_month($month, $this->year);
	}

	/**
	 * Return the array of all Calendar_Cell_Month instance of this year
	 * 
	 * @return array   an array contains Calendar_Cell_Month instances
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
	 * Return the current Calendar_Cell_Day instance
	 * 
	 * @return Calendar_Cell_Day
	 */
	public function current()
	{
		return $this->get_calendar()->get_day(1 + $this->_offset, 1, $this->year);
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
		return $this->year == date('Y', mktime(0, 0, 0, 1, 1 + $this->_offset, $this->year));
	}
}