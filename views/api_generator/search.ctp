<?php
/**
 * Api Search results
 *
 */
$paginator->options(array('url' => $this->passedArgs));
$apiDoc->setClassIndex($classIndex);
?>
<h1><?php echo sprintf(__('Search Results for "%s"', true), $this->passedArgs[0]); ?></h1>
<?php if (empty($docs)): ?>
	<p class="error"><?php __('Your search returned no results'); ?></p>
<?php return; endif;
foreach ($docs as $result) {
	foreach ($result['class'] as $name => $doc) { ?>
<div id="search-results" class="doc-block class-info">
<h2><?php echo $apiDoc->classLink($doc->name, array(), array('class' => false)); ?></h2><?php
		if ($doc->properties) {
			echo $this->element('properties', array('doc' => $doc, 'isSearch' => true));
		}
		if ($doc->methods) {
			echo $this->element('method_summary', array('doc' => $doc, 'isSearch' => true));
		}
		echo '</div>';
	}
}
echo $this->element('paging'); ?>