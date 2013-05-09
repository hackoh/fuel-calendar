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

class Calendar
{
	protected static $_instances = array();

	public static function _init()
	{
		\Config::load('calendar', true);
		static::forge('default');
	}

	public static function forge($name, $config = array())
	{
		if (isset(static::$_instances[$name]))
		{
			throw new \Exception();
		}
		static::$_instances[$name] = new static($name, $config);
		return static::$_instances[$name];
	}

	public static function instance($name = 'default')
	{
		if ( ! isset(static::$_instances[$name]))
		{
			throw new \Exception();
		}
		return static::$_instances[$name];
	}

	public static function year($year, $name = 'default')
	{
		return static::instance($name)->get_year($year);
	}

	public static function month($month, $year, $name = 'default')
	{
		return static::instance($name)->get_month($month, $year);
	}

	public static function week($week, $month, $year, $name = 'default')
	{
		return static::instance($name)->get_week($week, $month, $year);
	}

	public static function day($day, $month, $year, $name = 'default')
	{
		return static::instance($name)->get_day($day, $month, $year);
	}

	public static function holidays($glue = false, $name = 'default')
	{
		return static::instance($name)->get_holidays($glue);
	}

	protected $_name;
	protected $_config;
	protected $_years	= array();
	protected $_months	= array();
	protected $_weeks	= array();
	protected $_days	= array();

	public function __construct($name, $config = array())
	{
		$this->_name = $name;
		$this->_config = $config + \Config::get('calendar');
	}

	public function get_config($key)
	{
		return \Arr::get($this->_config, $key);
	}

	public function set_config($key, $value)
	{
		\Arr::set($this->_config, $key, $value);
	}

	/**
	 * [year description]
	 * @param  int $year
	 * @return \Calendar_Year
	 */
	public function get_year($year)
	{
		if ( ! isset($this->_years[$year]))
		{
			$this->_years[$year] = \Calendar_Cell_Year::forge($year, $this->_name);
		}
		return $this->_years[$year];
	}

	/**
	 * [month description]
	 * @param  int $month
	 * @param  int $year
	 * @return \Calendar_Month
	 */
	public function get_month($month, $year)
	{
		if ( ! isset($this->_months[$year][$month]))
		{
			$this->_months[$year][$month] = \Calendar_Cell_Month::forge($month, $year, $this->_name);
		}
		return $this->_months[$year][$month];
	}

	/**
	 * [week description]
	 * @param  int $week
	 * @param  int $month
	 * @param  int $year
	 * @return \Calendar_Week
	 */
	public function get_week($week, $month, $year)
	{
		if ( ! isset($this->_weeks[$year][$month][$week]))
		{
			$this->_weeks[$year][$month][$week] = \Calendar_Cell_Week::forge($week, $month, $year, $this->_name);
		}
		return $this->_weeks[$year][$month][$week];
	}

	/**
	 * [day description]
	 * @param  int $day
	 * @param  int $month
	 * @param  int $year
	 * @return \Calendar_Day
	 */
	public function get_day($day, $month, $year)
	{

		if ( ! $day)
		{
			$time = mktime(0, 0, 0, $month, $day, $year);
			$year = (int) date('Y', $time);
			$month = (int) date('n', $time);
			$day = (int) date('j', $time);
		}

		if ( ! isset($this->_days[$year][$month][$day]))
		{
			$this->_days[$year][$month][$day] = \Calendar_Cell_Day::forge($day, $month, $year, $this->_name);
		}
		return $this->_days[$year][$month][$day];
	}

	public function get_name()
	{
		return $this->_name;
	}

	public function get_holidays($glue = false)
	{
		$holidays = $this->get_config('holidays');
		$glue !== false and $holidays = \Arr::flatten($holidays, $glue);
		return $holidays;
	}

}