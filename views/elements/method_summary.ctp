<?php
/**
 * Method Summary Element
 *
 */
?>
<div class="doc-block">
	<a id="top"></a>
	<div class="doc-head"><h2>Method Summary:</h2></div>
	<div class="doc-body">
		<table class="summary">
			<tbody>
			<?php $i = 0; ?>
			<?php foreach ($doc->methods as $method): ?>
				<?php 
				if (isset($excludeNonPublic) && $excludeNonPublic && $method['access'] != 'public') :
					continue;
				endif;
				$definedInThis = ($method['declaredInClass'] == $doc->classInfo['name']);
				?>
				<tr class="<?php echo ($i % 2) ? 'even' : 'odd'; ?> <?php echo $definedInThis ? '' : 'parent-method'; ?>">
					<td class="access <?php echo $method['access']; ?>"><span><?php echo $method['access']; ?></span></td>
					<td><?php
						echo $html->link($method['name'], '#method-' . $method['name'], array('class' => 'scroll-link'));
					?></td>
					<td><?php echo $method['comment']['description']; ?></td>
				</tr>
				<?php $i++;?>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>