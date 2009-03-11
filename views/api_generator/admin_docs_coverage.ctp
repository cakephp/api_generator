<h1><?php __('Docs Coverage for '); echo $apiClass['ApiClass']['name']; ?></h1>
<div class="score-box">
	<div class="scorebar" style="width:<?php echo $number->precision($analysis['finalScore']) * 100; ?>%;">
		<span class="score"><?php echo $number->precision($analysis['finalScore']) * 100; ?> %</span>
	</div>
</div>
<h2><?php __('Docs analysis:')?></h2>
<?php 
foreach (array('methods', 'properties') as $key): 
	echo '<h3>' . $key . '</h3>';
	foreach ($analysis[$key] as $issue)  {
		echo $this->renderElement('docs_issue', array('issue' => $issue));
	}
endforeach; ?>