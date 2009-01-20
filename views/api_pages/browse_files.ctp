<?php
/* SVN FILE: $Id$ */
/**
 * Browse view.  Shows file listings and provides links to obtaining api docs from a file
 * Doubles as an ajax view by omitting certain tags when params['isAjax'] is set.
 */
?>
<?php if (!isset($this->params['isAjax']) && !$this->params['isAjax']): ?>
<h1 class="breadcrumb"><?php echo $this->element('breadcrumb'); ?></h1>
<ul id="file-list">
<?php endif; ?>

	<li class="folder previous-folder">
		<?php echo $html->link('Up one folder', array('action' => 'browse_files', $previousPath)); ?>
	</li>
<?php foreach ($dirs as $dir): ?>
	<li class="folder">
		<?php echo $html->link($dir, array('action' => 'browse_files', $currentPath . '/' . $dir)); ?>
	</li>
<?php endforeach; ?>
<?php if (!empty($files)): ?>
<?php foreach ($files as $file): ?>
	<li class="file">
		<?php echo $html->link($file, array('action' => 'view_file', $currentPath . '/' . $file)); ?>
	</li>
<?php endforeach; ?>
<?php else: ?>
	<li class="file">
		<?php __('No files'); ?>
	</li>
<?php endif; ?>

<?php if (!isset($this->params['isAjax']) && !$this->params['isAjax']): ?>
</ul>
<?php endif; ?>