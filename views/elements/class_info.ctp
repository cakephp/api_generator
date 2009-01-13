<?php
/**
 * Class information element
 *
 */
?>
<div id="classInfo" class="doc-block">
	<div class="doc-head"><h2>Class Info:</h2></div>
	<div class="doc-body">
	  <dl>
		<dt>Class Declaration:</dt>
		<dd><?php echo $doc->classInfo['classDescription']; ?></dd>
		<dt>File name:</dt>
		<dd><?php echo $apiDoc->trimFileName($doc->classInfo['fileName']); ?></dd>
		<dt>Summary:</dt>
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