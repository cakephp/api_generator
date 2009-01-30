<?php
/**
 * Paging Element
 *
 */
?>
<div class="paging">
	<?php if ($paginator->hasPrev()): ?>
		<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?> | 
	<?php endif; ?>
	
	<?php if ($paginator->hasPage(null, 2)): ?>
 		<?php echo $paginator->numbers(); ?>
	<?php endif; ?>

	<?php if ($paginator->hasNext()): ?>
		<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
	<?php endif;?>
</div>