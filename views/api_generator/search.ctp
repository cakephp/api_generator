<?php
/**
 * Api Search results
 *
 */
$apiDoc->setClassIndex($classIndex);
?>
<h1><?php echo sprintf(__('Search Results for "%s"', true), $this->passedArgs[0]); ?></h1>
<?php if (empty($docs)): ?>
	<p class="error"><?php __('Your search returned no results'); ?></p>
<?php return; 
endif; ?>

<ul id="search-results">
<?php foreach ($docs as $result):
	foreach ($result['class'] as $name => $doc): ?>
		<li class="doc-block class-info">
			<h2><?php echo $apiDoc->classLink($doc->name, array(), array('class' => false)); ?></h2><?php
		if ($doc->properties):
			echo $this->element('properties', array('doc' => $doc, 'isSearch' => true));
		endif;
		
		if ($doc->methods):
			echo $this->element('method_summary', array('doc' => $doc, 'isSearch' => true));
		endif;
?>
		</li>
<?php	
	endforeach;
endforeach;
?>
</ul>