<?php
/**
 * Method Summary Element
 *
 */

$apiUtils->sortByName($doc->methods); ?>
<div class="doc-block">
	<a id="top-<?php echo $doc->name; ?>"></a>
<?php if (!empty($isSearch)) { ?>
	<div class="doc-head"><h3><?php __('Methods:'); ?></h3></div>
<?php } else { ?>
	<div class="doc-head"><h2><?php __('Method Summary:'); ?></h2></div>
<?php } ?>
	<div class="doc-body">
<?php if (empty($isSearch)) { ?>
		<span class="doc-controls">
			<a href="#" id="hide-parent-methods"><?php __('Show/Hide parent methods'); ?></a>
		</span>
<?php } ?>
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
						if (empty($isSearch)) {
							echo $html->link($method['signature'],
								'#method-' . $doc->name . $method['name'],
								array('class' => 'scroll-link')
							);
						} else {
							echo $html->link($method['signature'],
								array('action' => 'view_class', $apiDoc->slugClassName($doc->name),
								'#' => 'method-' . $doc->name . $method['name']),
								array('class' => 'scroll-link')
							);
						}
					?>
					</td>
				</tr>
				<?php $i++;?>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>