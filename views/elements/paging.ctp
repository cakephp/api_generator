<?php
/**
 * Paging Element
 *
 */
?>
<div class="paging">
	<?php if ($paginator->hasPrev()): ?>
		<?php echo $paginator->prev('<< '.__d('api_generator', 'previous'), array(), null, array('class'=>'disabled'));?> | 
	<?php endif; ?>
	
	<?php if ($paginator->hasPage(null, 2)): ?>
 		<?php echo $paginator->numbers(); ?>
	<?php endif; ?>

	<?php if ($paginator->hasNext()): ?>
		<?php echo $paginator->next(__d('api_generator', 'next').' >>', array(), null, array('class'=>'disabled'));?>
	<?php endif;?>
</div>