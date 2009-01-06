<?php
/**
 * View file for multiple class files.
 * 
 */
echo $html->link('Go up a folder', array('action' => 'browse_files', $previousPath));

foreach ($classDocs as $class => $doc) :
	echo $this->element('class_info', array('doc' => $doc));
	echo $this->element('properties', array('doc' => $doc));
	echo $this->element('method_summary', array('doc' => $doc));
	echo $this->element('method_detail', array('doc' => $doc));
endforeach;
?>