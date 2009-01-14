<?php
/**
 * A Table of Contents for the elements in the consumed file.
 *
 */
?>
<div id="element-toc">
	<h2><?php __('Elements in '); echo $currentPath; ?></h2>
	<?php if (!empty($docs['function'])): ?>
		<h3><?php __('Functions'); ?></h3>
		<ul class="element-list">
		<?php foreach (array_keys($docs['function']) as $function): ?>
			<li class="function"><?php echo $html->link($function, "#function-".$function, array('class' => 'scroll-link')); ?></li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<?php if (!empty($docs['class'])): ?>
		<h3><?php __('Classes'); ?></h3>
		<ul class="element-list">
		<?php foreach (array_keys($docs['class']) as $class): ?>
			<li class="class"><?php echo $html->link($class, "#class-".$class, array('class' => 'scroll-link')); ?></li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>