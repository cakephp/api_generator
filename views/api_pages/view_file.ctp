<?php
/* SVN FILE: $Id$ */
/**
 * View view.  Shows generated api docs from a file.
 * 
 *
 */
?>
<div id="classInfo" class="doc-block">
	<div class="doc-head"><h2>Class Info:</h2></div>
	<div class="doc-body">
	  <dl>
		<dt>Class Declaration:</dt>
		<dd>{$doc.classInfo.classDescription}</dd>
		<dt>File name:</dt>
		<dd>{$doc.classInfo.fileName}</dd>
		<dt>Summary:</dt>
		<dd>{$doc.classInfo.comment.desc}</dd>
	  </dl>
	
	  <div class="tag-block">
		<dl>
	{foreach name=tags item=tag from=$doc.classInfo.comment.tags}
		{include file="$tplPath/Documenter/tags.tpl"}
	{/foreach}
		</dl>
	  </div>

	</div>
</div>

<div class="doc-block">
	<div class="doc-head"><h2>Properties:</h2></div>
	<div class="doc-body">
		<table>
		{foreach from=$doc.properties item=prop name=prop}
			<tr{if $smarty.foreach.prop.iteration % 2}
				 class="odd"
				{/if}>
				<td class="access {$prop.access}"><span>{$prop.access}</span></td>
				<td>{$prop.name}</td>
				<td>{$prop.comment.desc}</td>
			</tr>
		{/foreach}
		</table>
	</div>
</div>

<div class="doc-block">
	<div class="doc-head"><a id="top"></a><h2>Methods</h2></div>
	<div class="doc-body">
	<h3>Summary:</h3>
		<table class="summary">
			<tbody>
	{foreach from=$doc.methods item=method name=methods}
		<tr{if $smarty.foreach.methods.iteration % 2}
			 class="odd"
			{/if}>
			<td class="access {$method.access}"><span>{$method.access}</span></td>
			<td><a href="#{$method.name}">{$method.name}</a></td>
			<td>{$method.comment.desc|truncate:40 }</td>					
		</tr>
	{/foreach}
			</tbody>
		</table>
	</div>
</div>

{foreach from=$doc.methods item=method name=methods.detail}
<div class="doc-block">
	<div class="doc-head">
		<a id="{$method.name}"></a>
		<h2 class="{$method.access}">{$method.name}</h2>
		<a class="top-link" href="#top">top</a>
	</div>
	
	<div class="doc-body">
		<p>{$method.comment.desc}</p>
	<dl>
		{if $method.args|@count > 0}
		<dt>Parameters:</dt>
		<dd>
			<table>
				<tbody>
				{foreach from=$method.args item=arg name=args}
					<tr{if $smarty.foreach.args.iteration % 2}
						 class="odd"
						{/if}>
					{php}
						$arg = trim($this->get_template_vars('arg') );
						$pieces = explode("  ", $arg);
						echo "<td>{$pieces[0]}</td><td>{$pieces[1]}</td><td>{$pieces[2]}</td>";
					{/php}
					</tr>
				{/foreach}
				</tbody>
			</table>
		</dd>
		{/if}
		<dt>
			{foreach name=tags item=tag from=$method.comment.tags}
				{include file="$tplPath/Documenter/tags.tpl"}
			{/foreach}
		</dt>
	</div>
</div>
{/foreach}
