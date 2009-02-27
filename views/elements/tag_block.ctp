<?php
/**
 * Element for rendering tag sets.
 *
 */
?>
<div class="tag-block">
<dl>
	<?php foreach ($tags as $name => $value): ?>
		<dt><?php echo $name; ?></dt>
		<?php if (strtolower($name) == 'link'):
			echo '<dd>' . $text->autoLink(h($value)) . '</dd>';
		elseif (is_array($value)):
			foreach ($value as $line):
				echo '<dd>' . h($line) . '</dd>';
			endforeach;
		else:
			echo '<dd>' . h($value) . '</dd>';
		endif; ?>
	<?php endforeach; ?>
</dl>
</div>