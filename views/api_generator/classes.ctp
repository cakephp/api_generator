<?php
/**
 * Browse Classes View file
 *
 */
$letterIndex = array_flip(range('A', 'Z'));

foreach ($classIndex as $slug => $name):
	$firstLetter = strtoupper(substr($name, 0, 1));
	if (!is_array($letterIndex[$firstLetter])):
		$letterIndex[$firstLetter] = array();
	endif;
	$letterIndex[$firstLetter][$slug] = $name;
endforeach;
?>
<h1><?php __('Index'); ?></h1>

<div class="letter-links">
<?php
foreach (array_keys($letterIndex) as $letter):
	if (!is_array($letterIndex[$letter])) {
		echo '<span>' . $letter . '</span>';
	} else {
		echo $html->link($letter, '#letter-' . $letter);
	}
endforeach;
?>
</div>
<?php $letterChunks = array_chunk($letterIndex, floor(count($letterIndex)/3), true); ?>
<?php foreach ($letterChunks as $column => $letterList): ?>
	<div class="letter-section">
	<?php foreach ($letterList as $letter => $classes): ?>
		<?php if (is_array($classes)): ?>
			<h3><a id="letter-<?php echo $letter; ?>"></a><?php echo $letter; ?></h3>
			<ul class="class-index">
			<?php foreach ($classes as $slug => $name): ?>
				<li><?php
					echo $html->link($name, array(
						'plugin' => 'api_generator', 'controller' => 'api_generator',
						'action' => 'view_class', $slug));
				?></li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	<?php endforeach; ?>
	</div>
<?php endforeach; ?>