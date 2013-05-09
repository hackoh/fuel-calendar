Calendar
========

Calendar package for FuelPHP


Usage
------

```php

$data['year'] = \Calendar::year(2013);

echo View::forge('test/calendar', $data, false);

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
