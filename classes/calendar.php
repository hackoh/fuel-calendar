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
 * The Calendar class allows you to easily build calendars.
 * It allows you to set specify holidays.
 * It allows you to set specify free-data into cell instances.
 *
 * You can configure the holidays by copying the PKGPATH/calendar/config/calendar.php
 * config file into your app/config folder and changing the settings.
 */
class Calendar
{
	/**
	 * @var array contains references to all instantiations of Calendar
	 */
	protected static $_instances = array();

	/**
	 * Initialize Calendar class.
	 * @return void
	 */
	public static function _init()
	{
		// load the config.
		\Config::load('calendar', true);
	}

	/**
	 * Create Calendar object
	 * 
	 * @param  string $name   identifier for this calendar
	 * @param  array  $config Configuration array
	 * @return Calendar
	 */
	public static function forge($name, array $config = array())
	{
		if (isset(static::$_instances[$name]))
		{
			throw new \DomainException('Calendar instance already exists, cannot be recreated. Use instance() instead of forge() to retrieve the existing instance.');
		}
		static::$_instances[$name] = new static($name, $config);
		return static::$_instances[$name];
	}

	/**
	 * Return a specific instance, or the default instance (is created if necessary)
	 * 
	 * @param  string $name identifier
	 * @return Calendar
	 */
	public static function instance($name = 'default')
	{
		if ( ! isset(static::$_instances[$name]))
		{
			if ($name === 'default')
			{
				static::$_instances[$name] = static::forge($name);
			}
			else
			{
				throw new \OutOfBoundsException('Calendar instance named "'.$name.'" does not exists. Use forge() instead of instance() first.');
			}
		}
		return static::$_instances[$name];
	}

	/**
	 * Return a specific Calendar_Cell_Year instance.
	 * (This method is shortcut of the get_year() statically)
	 * 
	 * @param  int    $year specific year
	 * @param  string $name identifier of the calendar instance.
	 * @return Calendar_Cell_Year
	 */
	public static function year($year = null, $name = 'default')
	{
		return static::instance($name)->get_year($year);
	}

	/**
	 * Return a specific Calendar_Cell_Month instance.
	 * (This method is shortcut of the get_month() statically)
	 *
	 * @param  int    $month specific month
	 * @param  int    $year  specific year
	 * @param  string $name  identifier of the calendar instance.
	 * @return Calendar_Cell_Month
	 */
	public static function month($month = null, $year = null, $name = 'default')
	{
		return static::instance($name)->get_month($month, $year);
	}

	/**
	 * Return a specific Calendar_Cell_Week instance.
	 * (This method is shortcut of the get_week() statically)
	 * 
	 * @param  int    $week  specific week
	 * @param  int    $month specific month
	 * @param  int    $year  specific year
	 * @param  string $name  identifier of the calendar instance.
	 * @return Calendar_Cell_Week
	 */
	public static function week($week = null, $month = null, $year = null, $name = 'default')
	{
		return static::instance($name)->get_week($week, $month, $year);
	}

	/**
	 * Return a specific Calendar_Cell_Day instance.
	 * (This method is shortcut of the get_day() statically)
	 * 
	 * @param  int    $week  specific week
	 * @param  int    $month specific month
	 * @param  int    $year  specific year
	 * @param  string $name  identifier of the calendar instance.
	 * @return Calendar_Cell_Day
	 */
	public static function day($day = null, $month = null, $year = null, $name = 'default')
	{
		return static::instance($name)->get_day($day, $month, $year);
	}

	/**
	 * Return an array of holidays.
	 * 
	 * @param  boolean|string $glue the glue of joining  year/month/day. false to return a non-flatten array (default).
	 * @param  string         $name identifier of the calendar instance.
	 * @return array an array of holidays
	 */
	public static function holidays($glue = false, $name = 'default')
	{
		return static::instance($name)->get_holidays($glue);
	}

	/**
	 * Shortcut of the get_config() or set_config()
	 * 
	 * @param  mixed  $key
	 * @param  mixed  $value
	 * @param  string $name  identifier of the calendar instance.
	 * @return mixed
	 */
	public static function config($key = null, $value = null, $name = 'default')
	{
		if (is_null($key) and is_null($value))
		{
			return static::instance($name)->get_config();
		}
		elseif (is_null($value) and is_array($key))
		{
			return static::instance($name)->set_config($key);
		}
		elseif (is_null($value))
		{
			return static::instance($name)->get_config($key);
		}
		else
		{
			static::instance($name)->set_config($key, $value);
		}
	}

	/**
	 * identifier of the calendar instance
	 * 
	 * @var string
	 */
	protected $_name;

	/**
	 * the config
	 * 
	 * @var array
	 */
	protected $_config;

	/**
	 * an array of Calendar_Cell_Year
	 * 
	 * @var array
	 */
	protected $_years	= array();

	/**
	 * an array of Calendar_Cell_Month
	 * 
	 * @var array
	 */
	protected $_months	= array();

	/**
	 * an array of Calendar_Cell_Week
	 * 
	 * @var array
	 */
	protected $_weeks	= array();

	/**
	 * an array of Calendar_Cell_Day
	 * 
	 * @var array
	 */
	protected $_days	= array();

	/**
	 * Object constructor
	 * 
	 * @param string $name
	 * @param array  $config
	 */
	public function __construct($name, array $config = array())
	{
		$this->_name = $name;
		$this->_config = $config + \Config::get('calendar');
	}

	/**
	 * Get the config
	 * 
	 * @param  string $key dot-notated key
	 * @return mixed
	 */
	public function get_config($key)
	{
		return \Arr::get($this->_config, $key);
	}

	/**
	 * Set the config
	 * 
	 * @param [type] $key   dot-notated key
	 * @param [type] mixed  the value
	 */
	public function set_config($key, $value)
	{
		if (is_array($key))
		{
			foreach ($key as $k => $v)
			{
				$this->set_config($k, $v);
			}
		}
		else
		{
			\Arr::set($this->_config, $key, $value);
		}
	}

	/**
	 * Return a specific Calendar_Cell_Year instance..
	 * 
	 * @param  int $year
	 * @return \Calendar_Year
	 */
	public function get_year($year = null)
	{
		is_null($year) and $year = (int) date('Y');

		if ( ! isset($this->_years[$year]))
		{
			$this->_years[$year] = \Calendar_Cell_Year::forge($year);
			$this->_years[$year]->set_calendar_name($this->_name);
		}
		return $this->_years[$year];
	}

	/**
	 * Return a specific Calendar_Cell_Month instance.
	 * 
	 * @param  int $month
	 * @param  int $year
	 * @return \Calendar_Month
	 */
	public function get_month($month = null, $year = null)
	{
		is_null($month) and $month = (int) date('n');
		is_null($year) and $year = (int) date('Y');

		$time = mktime(0, 0, 0, $month, 1, $year);

		$month = (int) date('n', $time);
		$year = (int) date('Y', $time);

		if ( ! isset($this->_months[$year][$month]))
		{
			$this->_months[$year][$month] = \Calendar_Cell_Month::forge($month, $year);
			$this->_months[$year][$month]->set_calendar_name($this->_name);
		}
		return $this->_months[$year][$month];
	}

	/**
	 * Return a specific Calendar_Cell_Week instance.
	 * 
	 * @param  int $week
	 * @param  int $month
	 * @param  int $year
	 * @return \Calendar_Week
	 */
	public function get_week($week = null, $month = null, $year = null)
	{
		is_null($week) and $week = (int) date('W', mktime(0, 0, 0, $month, (int) date('j'), $year)) - (int) date('W', mktime(0, 0, 0, $month, 1, $year)) + 1;
		is_null($month) and $month = (int) date('n');
		is_null($year) and $year = (int) date('Y');

		$time = mktime(0, 0, 0, $month, 1, $year);

		$month = (int) date('n', $time);
		$year = (int) date('Y', $time);

		$w = \Calendar_Cell_Week::forge($week, $month, $year);
		$time = mktime(0, 0, 0, $w->month, $w->day, $w->year);

		if ( ! isset($this->_weeks[$time]))
		{
			$this->_weeks[$time] = $w;
			$this->_weeks[$time]->set_calendar_name($this->_name);
		}
		return $this->_weeks[$time];
	}

	/**
	 * Return a specific Calendar_Cell_Day instance.
	 * 
	 * @param  int $day
	 * @param  int $month
	 * @param  int $year
	 * @return \Calendar_Day
	 */
	public function get_day($day = null, $month = null, $year = null)
	{
		is_null($day) and $day = (int) date('j');
		is_null($month) and $month = (int) date('n');
		is_null($year) and $year = (int) date('Y');

		$time = mktime(0, 0, 0, $month, $day, $year);
		$year = (int) date('Y', $time);
		$month = (int) date('n', $time);
		$day = (int) date('j', $time);

		if ( ! isset($this->_days[$year][$month][$day]))
		{
			$this->_days[$year][$month][$day] = \Calendar_Cell_Day::forge($day, $month, $year);
			$this->_days[$year][$month][$day]->set_calendar_name($this->_name);
		}
		return $this->_days[$year][$month][$day];
	}

	/**
	 * Return the identifier of this instance.
	 * @return string
	 */
	public function get_name()
	{
		return $this->_name;
	}


	/**
	 * Return an array of holidays.
	 * 
	 * @param  boolean|string $glue the glue of joining  year/month/day. false to return a non-flatten array (default).
	 * @return array an array of holidays
	 */
	public function get_holidays($glue = false)
	{
		$holidays = $this->get_config('holidays');
		$glue !== false and $holidays = \Arr::flatten($holidays, $glue);
		return $holidays;
	}

}