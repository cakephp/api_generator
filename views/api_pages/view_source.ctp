<?php
/**
 * View the source code for a file.
 *
 */
?>
<h1><?php echo $filename; ?></h1>

<?php echo $apiUtils->highlight($contents); ?>
