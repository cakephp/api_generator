<?php
/* SVN FILE: $Id$ */
/**
 *
 * PHP versions 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.api_generator.layouts
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php __('CakePHP: API Generator'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php 
		echo $html->meta('icon');
		echo $html->css('/api_generator/css/base.css');
	?>
	<script type="text/javascript">
		var basePath = "<?php echo $this->base; ?>";
	</script>
	<?php
		echo $javascript->link('/api_generator/js/mootools');
		echo $javascript->link('/api_generator/js/showdown');
		echo $javascript->link('/api_generator/js/api_generator');

		echo $scripts_for_layout;
	?>
</head>
<body class="api">
	<?php $bodyClass = (isset($showSidebar) && $showSidebar) ? 'with-sidebar' : 'no-sidebar'; ?>
	<div id="wrapper" class="<?php echo $bodyClass; ?>">
		<div id="header" class="clearfix">
			<h1><?php echo $html->link(__('CakePHP: API Generator', true), 'http://cakephp.org'); ?></h1>
			<?php echo $this->element('header_search'); ?>
			<?php echo $this->element('api_menu');?>
		</div>
		<div id="content" class="clearfix">
			<?php $session->flash(); ?>
			<div id="content-inner">
				<?php echo $content_for_layout; ?>
			</div>
			<?php if (isset($showSidebar) && $showSidebar): ?>
			<div id="sidebar">
				<?php echo $this->element($sidebarElement)?>
			</div>
			<?php endif; ?>
		</div>
		<div id="footer">
			<?php echo $html->link(
					$html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework", true), 'border'=>"0")),
					'http://www.cakephp.org/',
					array('target'=>'_blank'), null, false
				);
			?>
		</div>
	</div>
</body>
</html>