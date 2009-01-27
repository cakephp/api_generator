<?php
/**
 * Function documentation element
 *
 */
?>
<a id="function-<?php echo $doc->name; ?>"></a>
<div class="function-info">
	<div class="doc-head">
		<h2><?php echo $doc->name; ?></h2>
		<a class="top-link scroll-link" href="#top-functions">top</a>
	</div>

	<div class="doc-body">
		<div class="markdown-block"><?php echo $doc->info['comment']['description']; ?></div>
	<dl>
		<?php if (count($doc->params)): ?>
		<dt><?php __('Parameters:'); ?></dt>
		<dd>
			<table>
				<tbody>
				<?php $i = 0; ?>
				<?php foreach ($doc->params as $name => $paramInfo): ?>
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
		
		<dt><?php __('Function defined in file:'); ?></dt>
		<dd><?php echo $apiDoc->fileLink($doc->info['declaredInFile']); ?></dd>
		
		<dt>
			<?php foreach ($doc->info['comment']['tags'] as $name => $value): ?>
				<dt><?php echo $name; ?></dt>
				<dd><?php echo $value; ?></dd>
			<?php endforeach; ?>
		</dt>
	</div>
</div>