<?php
/**
 * Describes issues with documentation
 *
 **/
?>
<div class="doc-issue">
	<h4><?php echo $issue['subject']; ?></h4>
	<dl>
	<?php foreach ($issue['scores'] as $problem): ?>
		<dt><?php echo $problem['description']; ?></dt>
		<dd><?php echo $problem['score']; ?></dd>
	<?php endforeach; ?>
	</dl>
</div>