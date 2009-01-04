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
 * A list of folders to ignore.
 *
 * @var array
 **/
	public $ignoreFolders = array('config', 'webroot');
/**
 * a list of extensions to scan for
 *
 * @var array
 **/
	public $extensionsToScan = array('php');
/**
 * A regexp for file names. (will be made case insenstive)
 *
 * @var string
 **/
	public $fileRegExp = '[a-z_\-0-9]+';
/**
 * DocumentorExtractor instance
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
 * Get a list of Objects that can have docs generated.
 *
 * @return void
 **/
	public function listObjects($type, $options = array()) {
		
	}
/**
 * Get a List of files that are known to contain classes
 *
 * @param string $basePath base path to start dir and extension scanning from (ends in DS)
 * @return array Array of all files matching the scan criteria.
 **/
	public function getFileList($basePath) {
		$found = array();
		$this->Folder = new Folder($basePath);
		$filePattern =  $this->fileRegExp . '\.' . implode('|', $this->extensionsToScan);
		$found = $this->Folder->findRecursive($filePattern);
		$count = count($found);
		foreach ($this->ignoreFolders as $remove) {
			$blackListed = DS . $remove . DS;
			for ($i = 0; $i < $count; $i++) {
				if (isset($found[$i]) && strpos($found[$i], $blackListed) !== false) {
					unset($found[$i]);
				}
			}
		}
		return $found;
	}

}
?>