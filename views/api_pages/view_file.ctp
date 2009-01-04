<?php
/* SVN FILE: $Id$ */
/**
 * View view.  Shows generated api docs from a file.
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
		<dd><?php echo $doc->classInfo['fileName']; ?></dd>
		<dt>Summary:</dt>
		<dd><?php echo $doc->classInfo['comment']['desc']; ?></dd>
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

<div class="doc-block">
	<div class="doc-head"><h2>Properties:</h2></div>
	<div class="doc-body">
		<table>
		<?php $i = 0; ?>
		<?php foreach ($doc->properties as $prop): ?>
			<tr class="<?php echo ($i % 2) ? 'even' : 'odd'; ?>">
				<td class="access <?php echo $prop['access']; ?>"><span><?php echo $prop['access']; ?></span></td>
				<td><?php echo $prop['name']; ?></td>
				<td><?php echo $prop['comment']['title'] . '<br />' . $prop['comment']['desc']; ?></td>
			</tr>
			<?php $i++;?>
		<?php endforeach; ?>
		</table>
	</div>
</div>

<div class="doc-block">
	<div class="doc-head"><a id="top"></a><h2>Methods</h2></div>
	<div class="doc-body">
	<h3>Summary:</h3>
		<table class="summary">
			<tbody>
			<?php $i = 0; ?>
			<?php foreach ($doc->methods as $method): ?>
				<tr class="<?php echo ($i % 2) ? 'even' : 'odd'; ?>">
					<td class="access <?php echo $method['access']; ?>"><span><?php echo $method['access']; ?></span></td>
					<td><a href="#method-<?php echo $method['name']; ?>"><?php echo $method['name']; ?></a></td>
					<td><?php echo $method['comment']['title'] . '<br />' . $method['comment']['desc']; ?></td>
				</tr>
				<?php $i++;?>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

{foreach from=$doc.methods item=method name=methods.detail}
<?php foreach ($doc->methods as $method): ?>
<div class="doc-block">
	<div class="doc-head">
		<a id="method-<?php echo $method['name']; ?>"></a>
		<h2 class="<?php echo $method['access'] ?>"><?php echo $method['name']; ?></h2>
		<a class="top-link" href="#top">top</a>
	</div>
	
	<div class="doc-body">
		<p><?php echo $method['comment']['title'] . '<br />' . $method['comment']['desc']; ?></p>
	<dl>
		<?php if (count($method['args'])): ?>
		<dt>Parameters:</dt>
		<dd>
			<table>
				<tbody>
				<?php $i = 0; ?>
				<?php foreach ($method['args'] as $name => $paramInfo): ?>
					<tr class="<?php echo ($i % 2) ? 'even' : 'odd'; ?>">
						<td><?php echo $name; ?></td>
						<td></td>
						<td></td>
					</tr>
					<?php $i++;?>
				<?php endforeach; ?>
<!--			{foreach from=$method.args item=arg name=args}
					<tr{if $smarty.foreach.args.iteration % 2}
						 class="odd"
						{/if}>
					{php}
						$arg = trim($this->get_template_vars('arg') );
						$pieces = explode("  ", $arg);
						echo "<td>{$pieces[0]}</td><td>{$pieces[1]}</td><td>{$pieces[2]}</td>";
					{/php}
					</tr>
				{/foreach} -->
				</tbody>
			</table>
		</dd>
		<?php endif; ?>
		<dt>
			<?php foreach ($method['comment']['tags'] as $name => $value): ?>
				<dt><?php echo $name; ?></dt>
				<dd><?php echo $value; ?></dd>
			<?php endforeach; ?>
		</dt>
	</div>
</div>
<?php endforeach; ?>
