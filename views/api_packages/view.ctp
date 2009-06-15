<?php
$apiDoc->setClassIndex($classIndex);
?>
<h1><?php printf(__('%s Package', true), $apiPackage['ApiPackage']['name']); ?></h1>

<?php if(!empty($apiPackage['ParentPackage'])): ?>
	<h3><?php __('Parent Package'); ?> </h3>
	<p><?php echo $apiDoc->packageLink($apiPackage['ParentPackage']['name']); ?></p>
<?php endif; ?>

<?php if (!empty($apiPackage['ChildPackage'])): ?>
	<h3><?php __('Child Packages'); ?></h3>
	<ul>
	<?php foreach ($apiPackage['ChildPackage'] as $child): ?>
		<li><?php echo $apiDoc->packageLink($apiPackage['ApiPackage']['name']); ?></li>
	<?php endforeach; ?>
	</ul>
<?php endif;?>

<h3><?php printf(__('Classes in %s', true), $apiPackage['ApiPackage']['name']); ?> </h3>
<ul>
<?php foreach ($apiPackage['ApiClass'] as $class): ?>
	<li><?php echo $apiDoc->classLink($class['name']); ?></li>
<?php endforeach; ?>
</ul>