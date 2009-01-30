<?php
/**
 * Method Summary Element
 *
 */

$apiUtils->sortByName($doc->methods); ?>
<div class="doc-block">
	<a id="top-<?php echo $doc->name; ?>"></a>
	<div class="doc-head"><h2><?php __('Method Summary:'); ?></h2></div>
	<div class="doc-body">
		<span class="doc-controls">
			<a href="#" id="hide-parent-methods"><?php __('Show/Hide parent methods'); ?></a>
		</span>
		<table class="summary">
			<tbody>
			<?php $i = 0; ?>
			<?php foreach ($doc->methods as $method): ?>
				<?php 
				if ($apiDoc->excluded($method['access'], 'method')) :
					continue;
				endif;
				$definedInThis = ($method['declaredInClass'] == $doc->classInfo['name']);
				?>
				<tr class="<?php echo ($i % 2) ? 'even' : 'odd'; ?> <?php echo $definedInThis ? '' : 'parent-method'; ?>">
					<td class="access <?php echo $method['access']; ?>"><span><?php echo $method['access']; ?></span></td>
					<td>
					<?php
						echo $html->link($method['signature'], 
							'#method-' . $doc->name . $method['name'], 
							array('class' => 'scroll-link')
						);
					?>
					</td>
				</tr>
				<?php $i++;?>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>