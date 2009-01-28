<?php
/**
 * Properties Element
 *
 */
?>
<div class="doc-block">
	<div class="doc-head"><h2>Properties:</h2></div>
	<div class="doc-body">
	<?php if (!empty($doc->properties)): ?>
		<span class="doc-controls">
			<a href="#" id="hide-parent-properties"><?php __('Show/Hide parent properties'); ?></a>
		</span>
		<table>
		<?php $i = 0; ?>
		<?php foreach ($doc->properties as $prop): ?>
			<?php 
			if ($apiDoc->excluded($prop['access'], 'property')) :
				continue;
			endif;
			$definedInThis = ($prop['declaredInClass'] == $doc->classInfo['name']);
			?>
			<tr class="<?php echo ($i % 2) ? 'even' : 'odd'; ?> <?php echo $definedInThis ? '' : 'parent-property'; ?>">
				<td class="access <?php echo $prop['access']; ?>"><span><?php echo $prop['access']; ?></span></td>
				<td><?php echo $prop['name']; ?></td>
				<td class="markdown-block"><?php echo $prop['comment']['description']; ?></td>
			</tr>
			<?php $i++;?>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>
	</div>
</div>