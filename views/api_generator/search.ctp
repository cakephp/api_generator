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
		<li><h4><?php echo $apiDoc->classLink($result['ApiClass']['name']); ?></h4>
			<?php $excerpt = $text->excerpt(strip_tags($result['ApiClass']['search_index']), $this->params['url']['query']); ?>
			<p><?php echo $text->highlight($excerpt, strtolower($this->params['url']['query'])); ?></p>
		</li>
	<?php endforeach;?>
</ul>
<?php endif; ?>
<?php 
$paginator->options(array(
	'url' => array(
		'?' => array('query' => $this->params['url']['query'])
	)
));
?>
<?php echo $this->element('paging'); ?>