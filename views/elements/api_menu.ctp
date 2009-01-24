<ul id="navigation">
	<li><?php echo $html->link(__('Api Home', true),
		array('plugin' => 'api_generator', 'controller' => 'api_generator', 'action' => 'index')); ?>
	</li>
	<li><?php echo $html->link(__('Browse Files', true),
		array('controller' => 'api_pages', 'action' => 'browse_files')); ?>
	</li>
	<li><?php echo $html->link(__('File List', true),
		array('controller' => 'api_pages', 'action' => 'list_files')); ?>
	</li>
	<li><?php echo $html->link(__('Browse Classes', true),
		array('controller' => 'api_pages', 'action' => 'browse_classes')); ?>
	</li>
</ul>