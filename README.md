Calendar
========

Calendar package for FuelPHP


Usage
------

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
