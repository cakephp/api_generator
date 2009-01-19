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
 * Uses array
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
 * undocumented class variable
 *
 * @var string
 **/
	public $helpers = array('ApiGenerator.ApiDoc', 'Html', 'Javascript');
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
	public function list_files() {
		$this->ApiFile = ClassRegistry::init('ApiGenerator.ApiFile');
		$files = $this->ApiFile->fileList($this->path);
		$this->set('files', $files);
	}
/**
 * Browse the classes in the application / API files.
 *
 * @return void
 **/
	public function browse_classes() {
		$this->ApiClass = ClassRegistry::init('ApiGenerator.ApiClass');
		$classList = $this->ApiClass->getClassIndex();
		$this->set('classList', $classList);
	}
/**
 * View the API docs for all interesting parts in a file.
 *
 * @return void
 **/
	public function view_file() {
		$this->ApiFile = ClassRegistry::init('ApiGenerator.ApiFile');
		$currentPath = implode('/', $this->passedArgs);
		$fullPath = $this->path . $currentPath;
		$previousPath = implode('/', array_slice($this->passedArgs, 0, count($this->passedArgs) -1));
		
		if (!file_exists($fullPath)) {
			$this->_notFound(__('No file exists with that name', true));
		}
		try {
			$docs = $this->ApiFile->loadFile($fullPath);
		} catch(Exception $e) {
			//do something later. Once I get missing classes == Exception.
		}

		$classList = ClassRegistry::init('ApiGenerator.ApiClass')->getClassIndex();

		list($dirs, $files) = $this->ApiFile->read($this->path . $previousPath);
		if (!empty($docs)) {
			$this->set('showSidebar', true);
			$this->set('sidebarElement', 'sidebar/file_sidebar');
			$this->set(compact('currentPath', 'previousPath', 'docs', 'dirs', 'files', 'classList'));
		} else {
			$this->set('previousPath', $previousPath);
			$this->render('no_class');
		}
	}
/**
 * View API docs for a single class used with browse_classes
 *
 * @return void
 **/
	public function view_class($classSlug = null) {
		if (!$classSlug) {
			$this->Session->setFlash(__('No class name was given', true));
			$this->redirect($this->referer());
		}
		$this->ApiClass = ClassRegistry::init('ApiGenerator.ApiClass');
		$this->ApiFile = ClassRegistry::init('ApiGenerator.ApiFile');
		$classInfo = $this->ApiClass->findBySlug($classSlug);
		if (empty($classInfo['ApiClass']['file_name'])) {
			$this->_notFound(__('No class exists in the index with that name', true));
		}
		try {
			$docs = $this->ApiFile->loadFile($classInfo['ApiClass']['file_name']);
			$doc = $docs['class'][$classInfo['ApiClass']['name']];
		} catch(Exception $e) {
			//do something later. Once I get missing classes == Exception.
		}
		
		$classList = $this->ApiClass->find('list', array('fields' => array('slug', 'name')));
		if (!empty($docs)) {
			$this->set('showSidebar', true);
			$this->set('sidebarElement', 'sidebar/class_sidebar');
			$this->set(compact('doc', 'classList'));
		} else {
			$this->_notFound(__("Oops, seems we couldn't get the documentation for that class.", true));
		}
		
	}
}
?>