<?php
/* SVN FILE: $Id$ */
/**
 * Api Generator Component
 *
 * 
 *
 * PHP versions 4 and 5
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
class ApiGeneratorComponent extends Object {
/**
 * Holds controller reference
 *
 * @var object
 */
	public $controller;
/**
 * File instance.
 *
 * @var object
 */
	protected $_file;
/**
 * initialize Callback
 *
 * @return void
 **/
	public function initialize($controller, $settings = array()) {
		$this->controller = $controller;
		$this->_file = new File();
	}
}
?>