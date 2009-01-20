<?php
/* SVN FILE: $Id$ */
/**
 * Api Docs Helper
 * 
 * Wraps common docs pages view functions
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
class ApiDocHelper extends AppHelper {
/**
 * Helpers used by ApiDocHelper
 *
 * @var array
 */
	public $helpers = array('Html');
	
/**
 * default Urls
 *
 * @var array
 **/
	protected $_defaultUrl = array(
		'file' => array(
			'controller' => 'api_pages',
			'action' => 'view_file',
			'plugin' => 'api_generator',
		),
		'class' => array(
			'controller' => 'api_pages',
			'action' => 'view_class',
			'plugin' => 'api_generator',
		),
	);
/**
 * classList 
 *
 * @var array
 **/
	protected $_classList = array();
/**
 * inBasePath
 * 
 * Check if a filename is within the ApiGenerator.basePath path
 *
 * @return boolean
 **/
	function inBasePath($filename) {
		$basePath = Configure::read('ApiGenerator.filePath');
		return (strpos($filename, $basePath) !== false);
	}
/**
 * Create a link to a filename if it is in the basePath
 *
 * @param string $filename Name of file to make link to.
 * @param array $url Additional url params you want for some reason.
 * @param array $attributes attributes for link if one is generated.
 * @return string either a link or plain text depending on files location relative to basepath
 **/
	public function fileLink($filename, $url = array(), $attributes = array()) {
		$url = array_merge($this->_defaultUrl['file'], $url);
		if ($this->inBasePath($filename)) {
			$trimmedName = $this->trimFileName($filename);
			$url[] = $trimmedName;
			return $this->Html->link($trimmedName, $url, $attributes);
		}
		return $filename;
	}
/**
 * trim the basePath from a filename so it can be used in links
 *
 * @return string $filename Filename to trim basepath from
 * @return string trimmed filename
 **/
	public function trimFileName($filename) {
		$basePath = Configure::read('ApiGenerator.filePath');
		return str_replace($basePath, '', $filename);
	}
/**
 * Set the Class list so that linkClassName will know which classes are in the index.
 *
 * @param array $classList The list of classes to use when making links.
 * @return void
 **/
	public function setClassIndex($classList) {
		$this->_classList = $classList;
	}
/**
 * Create a link to a class name if it exists in the classList
 *
 * @param string $className the class name you wish to make a link to
 * @param array $url A url array to override defaults
 * @param array $attributes Additional attributes for an html link if generated.
 * @return string Html link or plaintext
 **/
	public function classLink($className, $url = array(), $attributes = array()) {
		$url = array_merge($this->_defaultUrl['class'], $url);
		$listFlip = array_flip($this->_classList);
		if (array_key_exists($className, $listFlip)) {
			$url[] = $listFlip[$className];
			return $this->Html->link($className, $url, $attributes);
		}
		return $className;
	}
/**
 * Slugs a classname to match the format in the database.
 *
 * @param string $className Name of class to sluggify.
 * @return string
 **/
	public function slugClassName($className) {
		return str_replace('_', '-', Inflector::underscore($className));
	}
}