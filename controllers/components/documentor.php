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
App::import('Vendor', 'ApiGenerator.DocumentExtractor');

class DocumentorComponent extends Object {
/**
 * Holds controller reference
 *
 * @var object
 */
	public $controller;
/**
 * DocumentExtractor instance
 *
 * @var object
 **/
	protected $_extractor;
/**
 * initialize Callback
 *
 * @return void
 **/
	public function initialize($controller, $settings = array()) {
		$this->controller = $controller;
	}
/**
 * loadClass
 * 
 * Loads the documentation extractor for a given classname.
 *
 * @param string $name Name of class to load. 
 * @access public
 * @return void
 */
	public function loadClass($name) {
		$this->_extractor = new DocumentExtractor($name);
	}
/**
 * getClassDocs
 * 
 * Gets the parsed docs from the Extractor
 *
 * @return array Array with all the extracted docs.
 **/
	public function getClassDocs() {
		$this->_extractor->getAll();
		return $this->_extractor;
	}
/**
 * getExtractor
 *
 * Get the documentor extractor instance
 * 
 * @access public
 * @return object
 */	
	public function getExtractor() {
		return $this->_extractor;
	}
/**
 * loadFile
 * 
 * Load A File and extract docs for all classes contained in that file
 *
 * @param string $fullPath FullPath of the file you want to load.
 * @return array Array of all the docs from all the classes that were loaded as a result of the file being loaded.
 **/
	public function loadFile($filePath) {
		$baseClass = array();
		if (strpos($filePath, 'models') !== false) {
			$baseClass['Model'] = 'AppModel';
		}
		if (strpos($filePath, 'helpers') !== false) {
			$baseClass['Helper'] = 'AppHelper';
		}
		if (strpos($filePath, 'view') !== false) {
			$baseClass['View'] = 'View';
		}
		$this->_importBaseClasses($baseClass);
		
		$addedClasses = $this->_getClassNamesFromFile($filePath);
		$docs = array();
		foreach ($addedClasses as $class) {
			$this->loadClass($class);
			if ($this->getExtractor()->getFileName() == $filePath) {
				$docs[$class] = $this->getClassDocs();
			}
		}
		return $docs;
	}
/**
 * _getClassNamesFromFile
 * 
 * Fetches the class names contained in the target file.
 *
 * @return array
 **/
	protected function _getClassNamesFromFile($filePath) {
		$currentClassList = get_declared_classes();
		include $filePath;
		$newClasses = array_diff(get_declared_classes(), $currentClassList);
		return $newClasses;
	}
/**
 * Attempts to solve class dependancies by importing base CakePHP classes
 *
 * @return void
 **/
	protected function _importBaseClasses($classes = array()) {
		App::import('Core', array('Model', 'Helper', 'View'));
		foreach ($classes as $type => $class) {
			App::import($type, $class);
		}
	}
}
?>