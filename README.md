Calendar
========

Calendar package for FuelPHP


Usage
------

## Simple calendar.

```php

Package::load('calendar');

$years = array();

foreach (range(2013, 2020) as $year)
{
	$years[] = \Calendar::year($year);
}

echo View::forge('test/cal', array('years' => $years), false);

```

```html
<?php foreach ($years as $year): ?>
<h1><?php echo $year->year; ?></h1>
	<?php foreach ($year->get_months() as $month): ?>
	<h2><?php echo $month->month ?></h2>
	<table border="1">
		<?php foreach ($month->get_weeks() as $week): ?>
			<tr>
			<?php foreach ($week as $day): ?>
				<td style="background-color: <?php echo $day->month == $month->month ? ($day->is_holiday() ? 'pink' : 'white') : 'gray' ?>"><?php echo $day->format('j') ?></td>
			<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php endforeach; ?>
<?php endforeach ?>
```

## Setting data.

```php
Package::load('Calendar');

$people = array('hackoh', 'foo', 'bar');
foreach ($people as $person)
{
	\Calendar::forge($person);
}

\Calendar::day(9, 5, 2013, 'hackoh')->set_data("hackoh's birthday!");
\Calendar::day(25, 5, 2013, 'foo')->set_data("foo's birthday!");
\Calendar::day(8, 5, 2013, 'bar')->set_data("bar's birthday!");

echo View::forge('test/cal', array('people' => $people));
```

```html
<?php foreach ($people as $person): ?>
	<h1><?php echo $person; ?></h1>
	<table border="1">
		<?php foreach (\Calendar::month(5, 2013, $person) as $day): ?>
			<tr>
				<td>
					<?php echo $day->format('m/d') ?>
				</td>
				<td>
					<?php echo $day->get_data() ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endforeach ?>
```
