<?php
/**
 * View a single class
 *
 */
$apiDoc->setClassIndex($classIndex);

echo $this->element('class_info');
echo $this->element('properties');
echo $this->element('method_summary');
echo $this->element('method_detail');
?>