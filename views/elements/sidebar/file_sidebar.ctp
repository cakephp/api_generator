<?php
/**
 * Displays a File Listing Sidebar Hopefully filled with Ajax love.
 *
 */
?>
<?php echo $this->element('doc_controls'); ?>

<h3><?php __('File browser'); ?></h3>
<ul id="file-browser">
	<li class="up-dir folder">
		<?php echo $html->link(__('Up one folder', true), array(
				'action' => 'source', $upOneFolder)); 
		?>
	</li>
	<?php foreach ($dirs as $dir): ?>
		<li class="folder">
			<?php echo $html->link($dir, array('action' => 'source', $previousPath . '/' . $dir)); ?>
		</li>
	<?php endforeach; ?>
	
	<?php if (!empty($files)): ?>
		<?php foreach ($files as $file): ?>
			<li class="file">
				<?php echo $html->link($file, array('action' => 'view_file', $previousPath . '/' . $file)); ?>
			</li>
		<?php endforeach; ?>
	<?php else: ?>
		<li class="file">
			<?php __('No files'); ?>
		</li>
	<?php endif; ?>
</ul>