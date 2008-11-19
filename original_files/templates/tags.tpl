<dt>
	{php}
		$tag = trim($this->get_template_vars("tag") );
		echo ucwords( substr($tag, 1, strpos($tag, ' ',2)-1) );
	{/php}
</dt>
<dd>
	{php}
		echo substr($tag, strpos($tag, ' ') );
	{/php}
</dd>