<?php
/**
 * Properties Element
 *
 */
echo $apiUtils->element('before_properties');
$apiUtils->sortByName($doc->properties);
?>
<div class="doc-block">
	<div class="doc-head"><h3><?php __d('api_generator', 'Properties:'); ?></h3></div>
	<div class="doc-body">
	<?php if (!empty($doc->properties)): ?>
<?php if (empty($isSearch)): ?>
		<span class="doc-controls">
			<a href="#" id="hide-parent-properties"><?php __d('api_generator', 'Show/Hide parent properties'); ?></a>
		</span>
<?php endif; ?>
		<ul class="property-list">
			<?php foreach ($doc->properties as $prop):
				if ($apiDoc->excluded($prop['access'], 'property')) :
					continue;
				endif;
				$definedInThis = ($prop['declaredInClass'] == $doc->classInfo['name']);
				$classname = $prop['access'] . ($definedInThis ? '' : ' parent-property');
				?>
				<li class="<?php echo $classname; ?>">
					<h3>
					<span class="access <?php echo $prop['access']; ?>">
						<span><?php echo $prop['access']; ?></span>
					</span>
					<?php echo $prop['name']; ?>
					<?php
					if (!empty($prop['comment']['tags']['var'])):
						printf('<span class="property-type">%s</span>', $prop['comment']['tags']['var']);
					endif;
					?>
					</h3>
					<div class="markdown-block">
					<?php echo $apiDoc->parse($prop['comment']['description']); ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	</div>
</div>
<?php echo $apiUtils->element('after_properties'); ?>