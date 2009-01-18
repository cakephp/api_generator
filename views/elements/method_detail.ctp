<?php
/**
 * Method Detail element
 *
 */
?>
<?php foreach ($doc->methods as $method):
	if (isset($excludeNonPublic) && $excludeNonPublic && $method['access'] != 'public') :
		continue;
	endif;
	$definedInThis = ($method['declaredInClass'] == $doc->classInfo['name']);
?>
<div class="doc-block <?php echo $definedInThis ? '' : 'parent-method'; ?>">
	<a id="method-<?php echo $doc->name . $method['name']; ?>"></a>
	<div class="doc-head">
		<h2 class="<?php echo $method['access'] ?>"><?php echo $method['name']; ?></h2>
		<a class="top-link scroll-link" href="#top-<?php echo $doc->name; ?>">top</a>
	</div>

	<div class="doc-body">
		<div class="markdown-block"><?php echo $method['comment']['description']; ?></div>
	<dl>
		<?php if (count($method['args'])): ?>
		<dt><?php __('Parameters:'); ?></dt>
		<dd>
			<table>
				<tbody>
				<?php $i = 0; ?>
				<?php foreach ($method['args'] as $name => $paramInfo): ?>
					<tr class="<?php echo ($i % 2) ? 'even' : 'odd'; ?>">
						<td>$<?php echo $name; ?></td>
						<td><?php echo $paramInfo['type']; ?></td>
						<td><?php echo $paramInfo['comment']; ?></td>
						<td><?php echo ($paramInfo['optional']) ? 'optional' : 'required'; ?></td>
						<td><?php echo ($paramInfo['default']) ? $paramInfo['default'] : '(no default)'; ?></td>
					</tr>
					<?php $i++;?>
				<?php endforeach; ?>
				</tbody>
			</table>
		</dd>
		<?php endif; ?>
		
		<dt><?php __('Method defined in class:'); ?></dt>
		<dd><?php echo $html->link($method['declaredInClass'], array('action' => 'view_class', $method['declaredInClass'])); ?></dd>
		
		<dt><?php __('Method defined in file:'); ?></dt>
		<dd><?php echo $apiDoc->fileLink($method['declaredInFile']); ?></dd>
		
		<dt>
			<?php foreach ($method['comment']['tags'] as $name => $value): ?>
				<dt><?php echo $name; ?></dt>
				<dd><?php echo $value; ?></dd>
			<?php endforeach; ?>
		</dt>
	</div>
</div>
<?php endforeach; ?>