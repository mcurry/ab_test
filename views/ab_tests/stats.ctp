<table>
	<tr>
		<th><?php __('Key') ?></th>
		<th><?php __('Views') ?></th>
		<th><?php __('Conversions') ?></th>
		<th><?php __('Perc') ?></th>
	</tr>
	<?php foreach($data['AbTestVariate'] as $variate) { ?>
		<tr>
			<td><?php echo $variate['key'] ?></td>
			<td><?php echo $variate['views'] ?></td>
			<td><?php echo $variate['conversions'] ?></td>
			<td><?php if($variate['key'] == 'other/unknown') { echo 'N/A'; } else { echo round(100 * $variate['conversions'] / $variate['views'], 2); } ?>%</td>
		</tr>
	<?php } ?>
</table>