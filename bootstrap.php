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

Autoloader::add_core_namespace('Calendar');
Autoloader::add_classes(array(
	'Calendar\\Calendar'			=> __DIR__.'/classes/calendar.php',
	'Calendar\\Calendar_Cell'		=> __DIR__.'/classes/calendar/cell.php',
	'Calendar\\Calendar_Cell_Year'	=> __DIR__.'/classes/calendar/cell/year.php',
	'Calendar\\Calendar_Cell_Month'	=> __DIR__.'/classes/calendar/cell/month.php',
	'Calendar\\Calendar_Cell_Week'	=> __DIR__.'/classes/calendar/cell/week.php',
	'Calendar\\Calendar_Cell_Day'	=> __DIR__.'/classes/calendar/cell/day.php',
));