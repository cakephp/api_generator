<?php
/* SVN FILE: $Id$ */
/**
 * Api Pages Controller 
 *
 * Handles the browsing and API docs generation for all files in an app.
 *
 * PHP versions 5
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
 * @subpackage      cake.api_generator.controllers
 * @since           
 * @version         
 * @modifiedby      
 * @lastmodified    
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class ApiPagesController extends ApiGeneratorAppController {
/**
 * Name property
 *
 * @var string
 */
	public $name = 'ApiPages';
/**
 * Uses arrayy
 *
 * @var array
 */
	public $uses = array();
/**
 * Components array
 *
 * @var array
 **/
	public $components = array('ApiGenerator.Documentor');
/**
 * Browse an Application and find things you would like to generate API docs for.
 *
 * @return void
 **/
	public function browse() {
	
	}
/**
 * View the API docs for all classes in a file.
 *
 * @return void
 **/
	public function view($file = null) {
	
	}
}
?>