<?php
/* SVN FILE: $Id$ */
/**
 * Documentor Component
 *
 * Extract Documentation from any class by using reflection.
 *
 * PHP 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2006-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright       Copyright 2006-2008, Cake Software Foundation, Inc.
 * @link            http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package         cake
 * @subpackage      cake.cake.libs.
 * @since           CakePHP v 1.2.0.4487
 * @version         
 * @modifiedby      
 * @lastmodified    
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Vendor', 'ApiGenerator.Introspector');

class DocumentorComponent extends Object {
/**
 * Holds controller reference
 *
 * @var object
 */
	public $controller;
/**
 * initialize Callback
 *
 * @return void
 **/
	public function initialize($controller, $settings = array()) {
		$this->controller = $controller;
	}

/**
 * beforeRender Callback
 * Set vars based on config variables
 *
 * @return void
 **/
	public function beforeRender($controller) {
		$controller->set('excludeNonPublic', Configure::read('ApiGenerator.excludeNonPublic'));
		$controller->set('excludeClasses', Configure::read('ApiGenerator.excludeClasses'));
	}

}
?>