<h1><?php __('Docs Coverage for '); echo $apiClass['ApiClass']['name']; ?></h1>
<div class="score-box">
	<div class="scorebar" style="width:<?php echo $number->toPercentage($analysis['finalScore'] * 100); ?>;">
		<span class="score"><?php echo $number->toPercentage($analysis['finalScore'] * 100); ?></span>
	</div>
</div>
<h2><?php __('Docs analysis:')?></h2>
<h3><?php __('Class info:'); ?></h3>
<?php echo $this->element('docs_issue', array('issue' => $analysis['classInfo']));?>
<?php 
foreach (array('methods', 'properties') as $key): 
	echo sprintf('<h3>%s (%s)</h3>', $key, $number->toPercentage($analysis['sectionTotals'][$key]['average'] * 100));
	foreach ($analysis[$key] as $issue)  {
		echo $this->element('docs_issue', array('issue' => $issue));
	}
endforeach; ?>