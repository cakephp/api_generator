<?php
/**
 * Method Summary Element
 *
 */
echo $apiUtils->element('before_method_summary');
$apiUtils->sortByName($doc->methods); 
$title = (empty($isSearch)) ? __d('api_generator', 'Method Summary:', true) : __d('api_generator', 'Methods:', true);
?>
<div class="doc-block">
	<a id="top-<?php echo $doc->name; ?>"></a>
	<div class="doc-head"><h3><?php echo $title; ?></h3></div>
	<div class="doc-body">
<?php if (empty($isSearch)): ?>
		<span class="doc-controls">
			<a href="#" id="hide-parent-methods"><?php __d('api_generator', 'Show/Hide parent methods'); ?></a>
		</span>
<?php endif; ?>
		<ul class="method-summary">
			<?php foreach ($doc->methods as $method): ?>
				<?php 
				if ($apiDoc->excluded($method['access'], 'method')) :
					continue;
				endif;
				$parent = ($method['declaredInClass'] == $doc->classInfo['name']) ? '' : 'parent-method'; 
				?>
				<li class="<?php echo $parent; ?>">
					<span class="access <?php echo $method['access'] ?>">
					<?php
						if (empty($isSearch)):
							echo $this->Html->link($method['signature'],
								'#method-' . $doc->name . $method['name'],
								array('class' => 'scroll-link')
							);
						else:
							echo $this->Html->link($method['signature'],
								array('action' => 'view_class', $apiDoc->slug($doc->name),
								'#' => 'method-' . $doc->name . $method['name']),
								array('class' => 'scroll-link')
							);
						endif;
					?>
					</span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php echo $apiUtils->element('after_method_summary'); ?>