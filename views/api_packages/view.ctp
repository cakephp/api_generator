<?php
$apiDoc->setClassIndex($classIndex);
?>
<div class="api-package">
	<h1><?php printf(__('%s Package', true), $apiPackage['ApiPackage']['name']); ?></h1>

	<?php if(!empty($apiPackage['ParentPackage'])): ?>
		<h3><?php __('Parent Package'); ?> </h3>
		<ul class="package-list">
			<li><?php echo $apiDoc->packageLink($apiPackage['ParentPackage']['name']); ?></li>
		</ul>
	<?php endif; ?>

	<?php if (!empty($apiPackage['ChildPackage'])): ?>
		<h3><?php __('Child Packages'); ?></h3>
		<ul class="package-list">
		<?php foreach ($apiPackage['ChildPackage'] as $child): ?>
			<li><?php echo $apiDoc->packageLink($child['name']); ?></li>
		<?php endforeach; ?>
		</ul>
	<?php endif;?>

	<h3><?php printf(__('Classes in %s', true), $apiPackage['ApiPackage']['name']); ?> </h3>
	<ul class="package-list">
	<?php foreach ($apiPackage['ApiClass'] as $class): ?>
		<li><?php echo $apiDoc->classLink($class['name']); ?></li>
	<?php endforeach; ?>
	</ul>
</div>