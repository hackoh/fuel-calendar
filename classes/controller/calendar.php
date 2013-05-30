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
 * The Controller_Calendar class allows you to easily render calendars.
 */
class Controller_Calendar extends \Controller
{
	public function before()
	{
		if ( ! \Request::is_hmvc())
		{
			// This controller allows accessing via HMVC.
			throw new \HttpNotFoundException;
		}
	}

	public function action_year($year = null)
	{
		return \Response::forge(\View::forge('calendar/year', array('year' => Calendar::year($year))));
	}

	public function action_month($year = null, $month = null)
	{
		return \Response::forge(\View::forge('calendar/month', array('month' => Calendar::month($month, $year))));
	}
	
	public function action_week($year = null, $month = null, $week = null)
	{
		return \Response::forge(\View::forge('calendar/week', array('week' => Calendar::week($week, $month, $year))));
	}
}
