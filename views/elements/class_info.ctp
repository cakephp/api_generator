<?php
/**
 * Class information element
 *
 */
?>
<a id="class-<?php echo $doc->name; ?>"></a>
<div id="classInfo" class="doc-block">
	<div class="doc-head"><h2><?php echo $doc->name; ?> Class Info:</h2></div>
	<div class="doc-body">
	  <dl>
		<dt><?php __('Class Declaration:'); ?></dt>
		<dd><?php echo $doc->classInfo['classDescription']; ?></dd>
		
		<dt><?php __('File name:'); ?></dt>
		<dd><?php echo $apiDoc->trimFileName($doc->classInfo['fileName']); ?></dd>
		
		<dt><?php __('Summary:'); ?></dt>
		<dd class="markdown-block"><?php echo $doc->classInfo['comment']['description']; ?></dd>
	  </dl>
	  <div class="tag-block">
		<dl>
			<?php foreach ($doc->classInfo['comment']['tags'] as $name => $value): ?>
				<dt><?php echo $name; ?></dt>
				<dd><?php echo $value; ?></dd>
			<?php endforeach; ?>
		</dl>
	  </div>
	</div>
</div>