<?php
/**
 * View the source code for a file.
 *
 */
App::import('Vendor', 'ApiGenerator.highlight');

$highlight = new highlight();
?>
<h1><?php echo $filename; ?></h1>

<?php echo $highlight->process($contents); ?>
