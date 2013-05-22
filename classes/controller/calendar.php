<?php

namespace Calendar;

class Controller_Calendar extends \Controller
{
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
