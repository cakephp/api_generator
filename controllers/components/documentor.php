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
 * loadClass
 *
 * @param string $name Name of class to load. 
 * @access public
 * @return void
 */
	public function loadClass($name) {
		
	}
}
/**
 * Documentation Extractor
 *
 * Retrieves Documentation using PHP Class Reflection
 *
 * @package api_generator
 */
class DocumentExtractor extends ReflectionClass {
/**
 * getClassInfo
 *
 * Get Basic classInfo about the current class
 *
 * @return array Information about Class
 **/
	public function getClassInfo(){
		$this->classInfo['name'] = $this->getName();
		$this->classInfo['fileName'] = $this->getFileName();

		$desc = '';
		if ($this->isFinal()) {
			$desc .= 'final ';
		}
		if ($this->isAbstract()) {
			$desc .= 'abstract ';
		}
		if ($this->isInterface()) {
			$desc .= 'interface ';
		} else {
			$desc .= 'class ';
		}
		$desc .= $this->getName() . ' ';
		if ($this->getParentClass()) {
			$desc .= 'extends ' . $this->getParentClass()->getName();
		}

		$interfaces = $this->getInterfaces();
		$number = count($interfaces);
		if ($number > 0){
			$desc .= ' implements ';
			foreach ($interfaces as $int) {
				$desc .= $int->getName() . ' ';
			}
		}	

		$this->classInfo['classDescription'] = $desc;
		$this->classInfo['comment'] = $this->__cleanComment($this->getDocComment());

		return $this->classInfo;
	}

/**
 * cleanComment
 *
 * Cleans input comments of stars and /'s so it is more readable.
 * Creates a multi dimensional array. That contains semi parsed comments
 * 
 * 'title' contains the title / first line of the doc-block
 * 'desc' contains all information from the title to the @tags.
 * 'tags' contains all the doc-blocks @tags.
 * 
 * @param string $comments The comment block to be cleaned
 * @return array Array of Filtered and separated comments
 **/
	private function __cleanComment($comments){
		$com = array();

		//remove stars and slashes
		$tmp = str_replace('/**', '', $comments);
		$tmp = str_replace('* ', '', $tmp);
		$tmp = str_replace('*/', '', $tmp);
		$tmp = str_replace('*', '', $tmp);
		//fix new lines
		$tmp = str_replace("\r", "\n", $tmp);
		$tmp = str_replace("\n\n", "\n", $tmp);
		$tmp = str_replace("\t", "", $tmp);

		$tmp = explode("\n", trim($tmp));

		$com['title'] = $tmp[0];
		$desc = '';	
		$tags = array();
		for ($i = 1; $i < count($tmp); $i++ ){

			if (strlen($tmp[$i]) > 0 && substr(trim($tmp[$i]), 0, 1) !== '@') {
				$desc .= $tmp[$i];
			}
			if (substr(trim($tmp[$i]), 0, 1) == '@') {
				$tags[] = $tmp[$i];
			}

		}
		$com['desc'] = trim($desc);
		$com['tags'] = $tags;

		return $com;
	}
}
?>