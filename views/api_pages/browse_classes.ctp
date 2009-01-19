<?php
/**
 * Browse Classes View file
 *
 */
?>
<h1><?php __('Class Index'); ?></h1>
<ul id="classIndex">
<?php foreach ($classList as $slug => $name): ?>
	<li><?php echo $html->link($name, array('plugin' => 'api_generator', 'controller' => 'api_pages', 'action' => 'view_class', $slug)); ?></li>
<?php endforeach; ?>