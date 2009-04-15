<?php
/**
 * Recursive Listing of all allowed files.
 *
 */
$this->pageTitle = __('All Files', true);
?>
<h1><?php __('All files')?></h1>

<ul id="file-list">
<?php if (!empty($files)): ?>
<?php foreach ($files as $file): ?>
	<li class="file">
		<?php echo $apiDoc->fileLink($file); ?>
	</li>
<?php endforeach; ?>
<?php else: ?>
	<li class="file">
		<?php __('No files'); ?>
	</li>
<?php endif; ?>
</ul>