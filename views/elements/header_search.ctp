<?php
/**
 * Header search form 
 *
 */
?>
<?php echo $form->create('ApiClass', array('url' => array('controller' => 'api_pages', 'action' => 'search'), 'type' => 'get')); ?>
<fieldset id="search-bar">
	<?php echo $form->input('Search.query', array(
		'label' => false,
		'div' => false
	)); ?>
<?php echo $form->submit(__('Search', true), array('div' => false)); ?>
</fieldset>
<?php echo $form->end(null); ?>