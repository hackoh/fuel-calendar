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
abstract class Calendar_Cell
{
	/**
	 * [$_calenadar_name description]
	 * @var string
	 */
	protected $_calenadar_name = 'default';

	/**
	 * [$_params description]
	 * @var array
	 */
	protected $_params = array(
		'year'		=> null,
		'month'		=> null,
		'week'		=> null,
		'day'		=> null,
		'time'		=> null,
		'holiday'	=> null,
	);

	/**
	 * [$_data description]
	 * @var [type]
	 */
	protected $_data;

	/**
	 * [set_calendar_name description]
	 * @param [type] $name [description]
	 */
	public function set_calendar_name($name)
	{
		$this->_calenadar_name = $name;
	}

	/**
	 * [get_calendar_name description]
	 * @return [type] [description]
	 */
	public function get_calendar_name()
	{
		return $this->_calenadar_name;
	}

	/**
	 * [get_calendar description]
	 * @return [type] [description]
	 */
	public function get_calendar()
	{
		return \Calendar::instance($this->_calenadar_name);
	}


	/**
	 * [get_data description]
	 * @return [type] [description]
	 */
	public function get_data()
	{
		return $this->_data;
	}

	/**
	 * [set_data description]
	 * @param [type] $data [description]
	 */
	public function set_data($data)
	{
		$this->_data = $data;
	}

	/**
	 * [format description]
	 * @param  [type] $format [description]
	 * @return [type]         [description]
	 */
	public function format($format)
	{
		return date($format, $this->time);
	}

	/**
	 * [__get description]
	 * @param  [type] $property [description]
	 * @return [type]           [description]
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