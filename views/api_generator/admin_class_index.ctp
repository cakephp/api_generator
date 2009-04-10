<h1><?php __('Admin Class Index'); ?></h1>
<table class="listing" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th><?php __('Classname'); ?> </th>
			<th><?php __('Coverage'); ?>
			<th><?php __('Actions'); ?> </th>
		</tr>
	</thead>
	<?php foreach ($apiClasses as $apiClass): ?>
		<tr>
			<td><?php echo $apiClass['ApiClass']['name']; ?></td>
			<td><?php 
				if (!empty($apiClass['ApiClass']['coverage_cache'])): 
					echo $apiClass['ApiClass']['coverage_cache']; 
				else:
					echo '<span class="coverage-indicator" id="' . $apiClass['ApiClass']['id'] . '">Loading..</span>';
				endif;
			?></td>
			<td>
				<?php 
				echo $html->link(__('View Coverage', true), array('action' => 'docs_coverage', $apiClass['ApiClass']['slug'])); 
				?>
			</td>
		</tr>
	<?php endforeach ?>
</table>
<?php echo $this->element('paging'); ?>