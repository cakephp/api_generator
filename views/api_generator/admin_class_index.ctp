<h1><?php __('Admin Class Index'); ?></h1>
<table class="listing" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th><?php __('Classname'); ?> </th>
			<th><?php __('Actions'); ?> </th>
		</tr>
	</thead>
	<?php foreach ($apiClasses as $apiClass): ?>
		<tr>
			<td><?php echo $apiClass['ApiClass']['name']; ?></td>
			<td>
				<?php 
				echo $html->link(__('Docs Coverage', true), array('action' => 'docs_coverage', $apiClass['ApiClass']['slug'])); 
				?>
			</td>
		</tr>
	<?php endforeach ?>
</table>
<?php echo $this->element('paging'); ?>