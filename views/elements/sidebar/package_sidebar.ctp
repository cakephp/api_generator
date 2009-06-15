<?php
/**
 * Package index sidebar element
 *
 */
?>
<h3><?php __('Package Index'); ?></h3>
<?php echo $apiDoc->generatePackageTree($packageIndex); ?>