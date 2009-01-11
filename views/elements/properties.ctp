<?php
/**
 * Properties Element
 *
 */
?>
<div class="doc-block">
	<div class="doc-head"><h2>Properties:</h2></div>
	<div class="doc-body">
		<table>
		<?php $i = 0; ?>
		<?php foreach ($doc->properties as $prop): ?>
			<tr class="<?php echo ($i % 2) ? 'even' : 'odd'; ?>">
				<td class="access <?php echo $prop['access']; ?>"><span><?php echo $prop['access']; ?></span></td>
				<td><?php echo $prop['name']; ?></td>
				<td><?php echo $prop['comment']['desc']; ?></td>
			</tr>
			<?php $i++;?>
		<?php endforeach; ?>
		</table>
	</div>
</div>