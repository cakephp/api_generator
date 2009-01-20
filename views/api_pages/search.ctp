<?php
/**
 * Api Search results
 *
 */
$apiDoc->setClassIndex($classIndex);
?>
<h1><?php __('Search Results'); ?></h1>
<?php if (empty($results)): ?>
	<p class="error"><?php __('Your search returned no results'); ?></p>
<?php else: ?>
<ul id="search-results">
	<?php foreach ($results as $result): ?>
		<li><?php echo $apiDoc->classLink($result['ApiClass']['name']); ?>
	<?php endforeach;?>
</ul>
<?php endif; ?>
<?php echo $this->element('paging'); ?>