<?php
/**
 * No class view file. Displayed when no class is found.
 *
 */
?>
<h2><?php __('No classes were found in the requested file'); ?></h2>
<p class="folder">
	<?php echo $html->link('Up one folder', array('action' => 'source', $previousPath)); ?>
</p>
