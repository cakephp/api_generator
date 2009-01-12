<?php
/* SVN FILE: $Id$ */
/**
 * View view.  Shows generated api docs from a file.
 * 
 */
?>
<h1 class="breadcrumb"><?php echo $this->element('breadcrumb'); ?></h1>
<?php
echo $this->element('class_info');
echo $this->element('doc_controls');
echo $this->element('properties');
echo $this->element('method_summary');
echo $this->element('method_detail');
?>
