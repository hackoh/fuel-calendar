<h2><?php echo $week->year ?>/<?php echo $week->month ?> - week<?php echo $week->week ?></h2>
<table border="1">
	<tr>
	<?php foreach ($week as $day): ?>
		<td style="background-color: <?php echo $day->is_holiday() ? 'pink' : 'white' ?>"><span><?php echo $day->format('j') ?></span><p><?php echo $day->get_data() ?></p></td>
	<?php endforeach; ?>
	</tr>
</table>