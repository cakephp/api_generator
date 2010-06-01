<?php
/**
 * Method Detail element
 *
 */
echo $apiUtils->element('before_method_detail');
?>
<?php foreach ($doc->methods as $method):
	if ($apiDoc->excluded($method['access'], 'method')) :
		continue;
	endif;
	$definedInThis = ($method['declaredInClass'] == $doc->classInfo['name']);
?>
<div class="doc-block <?php echo $definedInThis ? '' : 'parent-method'; ?>">
	<a id="method-<?php echo $doc->name . $method['name']; ?>"></a>
	<div class="doc-head">
		<h2 class="access <?php echo $method['access'] ?>"><?php echo $method['name']; ?></h2>
		<a class="top-link scroll-link" href="#top-<?php echo $doc->name; ?>"><?php __d('api_generator', 'top'); ?></a>
	</div>

	<div class="doc-body">
		<div class="markdown-block"><?php echo $apiDoc->parse($method['comment']['description']); ?></div>
	<dl>
		<?php if (count($method['args'])): ?>
		<dt><?php __d('api_generator', 'Parameters:'); ?></dt>
		<dd>
			<ul class="argument-list">
				<?php foreach ($method['args'] as $name => $paramInfo): ?>
				<li>
					<div class="argument-properties">
						<span class="type"><?php echo $paramInfo['type']; ?></span>
						<span class="name">$<?php echo $name; ?></span>
						<span class="required"><?php echo $paramInfo['optional'] ? 'optional' : 'required' ?></span>
						<?php if ($paramInfo['optional'] == true): ?>
						<span class="default"><?php 
							echo ($paramInfo['hasDefault']) ? var_export($paramInfo['default'], true) : __d('api_generator', '(no default)', true); ?>
						</span>
						<?php endif; ?>
					</div>
					<div class="markdown-block">
						<?php echo $apiDoc->parse($paramInfo['comment']); ?>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		</dd>
		<?php endif; ?>
		
		<dt><?php __d('api_generator', 'Method defined in class:'); ?></dt>
		<dd><?php echo $apiDoc->classLink($method['declaredInClass']); ?></dd>
		
		<dt><?php __d('api_generator', 'Method defined in file:'); ?></dt>
		<dd><?php 
			echo $apiDoc->fileLink($method['declaredInFile']);
			
			if ($apiDoc->inClassIndex($method['declaredInClass'])):
				__d('api_generator', ' on line ');
				echo $this->Html->link($method['startLine'], array(
					'controller' => 'api_classes',
					'action' => 'view_source', 
					$apiDoc->slug($method['declaredInClass']),
					'#line-'. $method['startLine']
				));
			endif;
		?> </dd>
		</dl>
		<?php echo $this->element('tag_block', array('tags' => $method['comment']['tags'])); ?>
	</div>
</div>
<?php
endforeach;
echo $apiUtils->element('after_method_detail');
?>