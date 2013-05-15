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
 * The abstract Calender_Cell class has free-data and read-only params.
 * And this belongs to a Calendar instance.
 * (default calendar name is "default")
 */
abstract class Calendar_Cell
{
	/**
	 * the calendar instance name
	 * @var string
	 */
	protected $_calenadar_name = 'default';

	/**
	 * an array of read-only params
	 * @var array
	 */
	protected $_params = array(
		'time' => null
	);

	/**
	 * free-data
	 * @var mixed
	 */
	protected $_data;

	/**
	 * Set the calendar instance name
	 * 
	 * @param string $name
	 */
	public function set_calendar_name($name)
	{
		$this->_calenadar_name = $name;
	}

	/**
	 * Return the calendar instance name
	 * 
	 * @return string
	 */
	public function get_calendar_name()
	{
		return $this->_calenadar_name;
	}

	/**
	 * Return the calendar instance
	 * 
	 * @return Calendar
	 */
	public function get_calendar()
	{
		return \Calendar::instance($this->_calenadar_name);
	}


	/**
	 * Return the free-data
	 * 
	 * @return mixed
	 */
	public function get_data()
	{
		return $this->_data;
	}

	/**
	 * Set the free-data
	 * 
	 * @param mixed
	 */
	public function set_data($data)
	{
		$this->_data = $data;
	}

	/**
	 * Return the formatted date string
	 * Format-string is same as date()
	 * 
	 * @param  string $format The format of the outputted date string
	 * @return string Returns a formatted date string.
	 */
	public function format($format)
	{
		// Return the formatted string using "time" property
		return date($format, $this->time);
	}

	/**
	 * Return read-only params
	 * 
	 * @param  string $property property name
	 * @return mixed
	 */
	public function __get($property)
	{
		if (array_key_exists($property, $this->_params))
		{
			return $this->_params[$property];
		}
		else
		{
			throw new \OutOfBoundsException('Property "'.$property.'" not found for '.get_called_class().'.');
		}
	}
}