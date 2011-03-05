<?php
	$controlConversions = $data['AbTestVariate'][0]['conversions'];
	$controlViews = $data['AbTestVariate'][0]['views'];

	$variateConversions = $data['AbTestVariate'][1]['conversions'];
	$variateViews = $data['AbTestVariate'][1]['views'];

	$controlP = $controlConversions / $controlViews;
	$variateP = $variateConversions / $variateViews;

	$stdErr = sqrt(($controlP * (1 - $controlP) / $controlViews) + ($variateP * (1 - $variateP)  / $variateViews));
	$zValue = ($variateP - $controlP) / $stdErr;

	$a1 = 0.0498673470;
	$a2 = 0.0211410061;
	$a3 = 0.0032776263;
	$a4 = 0.0000380036;
	$a5 = 0.0000488906;
	$a6 = 0.0000053830;

	$absZ = abs($zValue);

	$temp = 1 + $absZ * ($a1+$absZ*($a2+$absZ*($a3+$absZ*($a4+$absZ*($a5+$absZ*$a6)))));
	$temp = pow($temp, 16);
	$pValue = 100 * (1 - round(1.0 / ($temp + $temp), 4));
?>
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
	<tr>
		<td>P-value</td>
		<td colspan=3><?php echo $pValue ?>%</td>
	</tr>
</table>