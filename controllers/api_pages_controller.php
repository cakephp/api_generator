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
 * Browse application files and find things you would like to generate API docs for.
 *
 * @return void
 **/
	public function browse_files() {
		$this->ApiFile = ClassRegistry::init('ApiGenerator.ApiFile');
		$currentPath = implode('/', $this->passedArgs);
		$previousPath = implode('/', array_slice($this->passedArgs, 0, count($this->passedArgs) -1));
		list($dirs, $files) = $this->ApiFile->read($this->path . $currentPath);
		$this->set(compact('dirs', 'files', 'currentPath', 'previousPath'));
	}
/**
 * all_files
 * 
 * Gets a recursive list of all files that match documentor criteria.
 *
 * @access public
 * @return void
 */
	public function all_files() {
		//$files = $this->Documentor->getFileList($this->path);
	}
/**
 * Browse the classes in the application / API files.
 *
 * @return void
 **/
	public function browse_classes() {
		
	}
/**
 * View the API docs for all classes in a file.
 *
 * @return void
 **/
	public function view_file() {
		$currentPath = implode('/', $this->passedArgs);
		$fullPath = $this->path . $currentPath;
		$previousPath = implode('/', array_slice($this->passedArgs, 0, count($this->passedArgs) -1));
		
		if (!file_exists($fullPath)) {
			$this->_notFound('No file exists with that name');
		}
		
		$classDocs = $this->Documentor->loadFile($fullPath);
		
		if (count($classDocs) > 1) {
			$this->set(compact('classDocs', 'previousPath'));
			$this->render('multiple_classes');
		} else {
			$this->set(array('previousPath' => $previousPath, 'doc' => array_pop($classDocs)));
		}
	}
/**
 * View API docs for a single class used with browse_classes
 *
 * @return void
 **/
	public function view_class($class = null) {
		
	}
}
?>