<?php
/* SVN FILE: $Id$ */
/**
 * View view.  Shows generated api docs from a file.
 * 
 */

echo $this->element('class_info');
echo $this->element('properties');
echo $this->element('method_summary');
echo $this->element('method_detail');
?>
