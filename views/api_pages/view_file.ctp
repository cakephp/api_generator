<?php
/* SVN FILE: $Id$ */
/**
 * View view.  Shows generated api docs from a file.
 * 
 */
?>
<p class="folder previous-folder">
	<?php echo $html->link('Go up a folder', array('action' => 'browse_files', $previousPath)); ?>
</p>
<?php
echo $this->element('class_info');
echo $this->element('properties');
echo $this->element('method_summary');
echo $this->element('method_detail');
?>
