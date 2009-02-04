<?php
/**
 * Class information element
 *
 */
?>
<a id="class-<?php echo $doc->name; ?>"></a>
<div class="doc-block class-info">
	<div class="doc-head"><h2><?php echo $doc->name; ?> Class Info:</h2></div>
	<div class="doc-body">
	  <dl>
		<dt><?php __('Class Declaration:'); ?></dt>
		<dd><?php echo $doc->classInfo['classDescription']; ?></dd>
		
		<dt><?php __('File name:'); ?></dt>
		<dd><?php echo $apiDoc->trimFileName($doc->classInfo['fileName']); ?></dd>
		
		<dt><?php __('Summary:'); ?></dt>
		<dd class="markdown-block"><?php echo h($doc->classInfo['comment']['description']); ?></dd>
		
		<?php if (!empty($doc->classInfo['parents'])): ?>
		<dt><?php __('Class Inheritance'); ?></dt>
		<dd><?php echo $apiDoc->inheritanceTree($doc->classInfo['parents']); ?></dd>
		<?php endif;?>
		
		<?php if (!empty($doc->classInfo['interfaces'])): ?>
		<dt><?php __('Interfaces Implemented'); ?></dt>
		<dd>
			<?php foreach ($doc->classInfo['interfaces'] as $interfaces): ?>
		        <?php echo $apiDoc->classLink($interfaces); ?>
			<?php endforeach; ?>
		</dd>
		<?php endif;?>
		
	  </dl>
	  <div class="tag-block">
		<dl>
			<?php foreach ($doc->classInfo['comment']['tags'] as $name => $value): ?>
				<dt><?php echo $name; ?></dt>
				<?php if (strtolower($name) == 'link'):
					echo '<dd>' . $text->autoLink(h($value)) . '</dd>';
				else:
					echo '<dd>' . h($value) . '</dd>';
				endif; ?>
			<?php endforeach; ?>
		</dl>
	  </div>
	</div>
</div>