<?php
/**
 * View file for multiple class files.
 * 
 */
?>
<h1 class="breadcrumb"><?php echo $this->element('breadcrumb'); ?></h1>
<?php
foreach ($classDocs as $class => $doc) :
	echo $this->element('class_info', array('doc' => $doc));
	echo $this->element('properties', array('doc' => $doc));
	echo $this->element('method_summary', array('doc' => $doc));
	echo $this->element('method_detail', array('doc' => $doc));
endforeach;
?>