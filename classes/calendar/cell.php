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

abstract class Calendar_Cell
{
	protected $_calenadar_name = 'default';
	protected $_params = array(
		'year'		=> null,
		'month'		=> null,
		'week'		=> null,
		'day'		=> null,
		'time'		=> null,
		'holiday'	=> null,
	);
	protected $_data;

	public function get_calendar()
	{
		return \Calendar::instance($this->_calenadar_name);
	}

	public function get_data()
	{
		return $this->_data;
	}

	public function set_data($data)
	{
		$this->_data = $data;
	}

	public function format($format)
	{
		return date($format, $this->time);
	}

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