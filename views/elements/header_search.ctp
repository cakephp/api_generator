<?php
/**
 * Header search form 
 *
 */
?>
<div id="header-search">
<?php echo $form->create('ApiClass', array(
	'url' => array(
		'plugin' => 'api_generator', 'controller' => 'api_generator', 
		'action' => 'search'
	), 
	'type' => 'get',
)); ?>
<fieldset id="search-bar">
	<?php 
	echo $form->text('Search.query', array(
		'class' => 'query'
	)); ?>
<?php echo $form->submit(__('Search', true), array('div' => false, 'class' => 'submit')); ?>
</fieldset>
<?php echo $form->end(null); ?>
</div>