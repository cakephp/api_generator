<?php
/* SVN FILE: $Id$ */
/**
 * Browse view.  Shows file listings and provides links to obtaining api docs from a file
 *
 */
?>
<h1><?php echo $currentPath; ?></h1>
<p class="back">
	<?php echo $html->link('Up one folder', array('action' => 'browse_files', $previousPath)); ?>
</p>
<ul id="file-list">
<?php foreach ($dirs as $dir): ?>
	<li class="folder">
		<?php echo $html->link($dir, array('action' => 'browse_files', $currentPath . '/' . $dir)); ?>
	</li>
<?php endforeach; ?>
<?php foreach ($files as $file): ?>
	<li class="file">
		<?php echo $html->link($file, array('action' => 'view_file', $currentPath . '/' . $file)); ?>
	</li>
<?php endforeach; ?>
</ul>