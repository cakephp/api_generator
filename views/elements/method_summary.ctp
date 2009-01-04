<?php
/**
 * Method Summary Element
 *
 */
?>
<div class="doc-block">
	<div class="doc-head"><a id="top"></a><h2>Methods</h2></div>
	<div class="doc-body">
	<h3>Summary:</h3>
		<table class="summary">
			<tbody>
			<?php $i = 0; ?>
			<?php foreach ($doc->methods as $method): ?>
				<tr class="<?php echo ($i % 2) ? 'even' : 'odd'; ?>">
					<td class="access <?php echo $method['access']; ?>"><span><?php echo $method['access']; ?></span></td>
					<td><a href="#method-<?php echo $method['name']; ?>"><?php echo $method['name']; ?></a></td>
					<td><?php echo $method['comment']['title'] . '<br />' . $method['comment']['desc']; ?></td>
				</tr>
				<?php $i++;?>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>