<h1><?php echo $year->year; ?></h1>
<?php foreach ($year->get_months() as $month): ?>
<h2><?php echo $month->month ?></h2>
<table border="1">
	<?php foreach ($month->get_weeks() as $week): ?>
		<tr>
		<?php foreach ($week as $day): ?>
			<td style="background-color: <?php echo $day->month == $month->month ? ($day->is_holiday() ? 'pink' : 'white') : 'gray' ?>"><span><?php echo $day->format('j') ?></span><p><?php echo $day->get_data() ?></p></td>
		<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
</table>
<?php endforeach; ?>