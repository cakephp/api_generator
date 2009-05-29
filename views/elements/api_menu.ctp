<ul class="navigation">
	<li><?php
		$class = ($this->action == 'classes') ? array('class' => 'on') : null;
		echo $html->link(__('Classes', true), array(
			'plugin' => 'api_generator',
			'controller' => 'api_classes', 'action' => 'classes'
			), $class);?>
	</li>
	<li><?php
		$class = ($this->action == 'source') ? array('class' => 'on') : null;
		echo $html->link(__('Source', true), array(
			'plugin' => 'api_generator',
			'controller' => 'api_files', 'action' => 'source'
			), $class);?>
	</li>
	<li><?php
		$class = ($this->action == 'files') ? array('class' => 'on') : null;
		echo $html->link(__('Files', true), array(
			'plugin' => 'api_generator',
			'controller' => 'api_files', 'action' => 'files'
			), $class);?>
	</li>
</ul>