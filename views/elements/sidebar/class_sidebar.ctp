<?php
/**
 * Class List sidebar element
 *
 */
?>
<h3><?php __('Class Index'); ?></h3>
<ul class="class-index">
<?php foreach ($classIndex as $slug => $name): ?>
	<li class="class">
		<?php 
		echo $html->link($name, array(
			'plugin' => 'api_generator', 'controller' => 'api_classes',
			'action' => 'view_class', $slug
		));
	?></li>
<?php endforeach; ?>