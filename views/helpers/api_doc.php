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
 * internal basePath used when browsing files. and making links to them
 *
 * @var string
 **/
	protected $_basePath;
/**
 * default Urls
 *
 * @var array
 **/
	protected $_defaultUrl = array(
		'file' => array(
			'controller' => 'api_generator',
			'action' => 'view_file',
			'plugin' => 'api_generator',
		),
		'class' => array(
			'controller' => 'api_generator',
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
 * Constructor.
 *
 * @return void
 **/
	public function __construct($config = array()) {
		$view = ClassRegistry::getObject('view');
		$this->_basePath = $view->getVar('basePath');
	}
/**
 * set the basePath
 *
 * @return void
 **/
	public function setBasePath($path) {
		$this->_basePath = $path;
	}
/**
 * inBasePath
 * 
 * Check if a filename is within the ApiGenerator.basePath path
 *
 * @return boolean
 **/
	function inBasePath($filename) {
		return (strpos($filename, $this->_basePath) !== false);
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
		return str_replace($this->_basePath, '', $filename);
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
 * Check if a class is in the classIndex
 *
 * @param string $className The class 
 * @return boolean
 **/
	public function inClassIndex($className) {
		return in_array($className, $this->_classList);
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
 * Check the access string against the excluded method access.
 *
 * @param string $accessString name of the accessString you are checking ie. public
 * @param string $type Type of access to check, (method or property)
 * @return boolean
 **/
	public function excluded($accessString, $type) {
		$view = ClassRegistry::getObject('view');
		$accessName = Inflector::variable('exclude_' . Inflector::pluralize($type));
		$exclusions = $view->getVar($accessName);
		if (in_array($accessString, $exclusions)) {
			return true;
		}
		return false;
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
/**
 * Create a nested inheritance tree from an array.
 * Uses an array stack like a tree. So
 *     array('foo', 'bar', 'baz')
 * will create a tree like
 *  * foo
 *  ** bar
 *  *** baz
 *
 * @param array $parents Array of parents you want to make into a tree
 * @return string
 **/
	public function inheritanceTree($parents) {
		$out = $endTags = '';
		$totalParents = count($parents);
		foreach ($parents as $i => $class) {
			$htmlClass = 'parent-class';
			if ($i == $totalParents - 1) {
				$htmlClass .= ' last';
			}
			$out .= '<span class="' . $htmlClass . '">' . $this->classLink($class) . "</span>\n";
		}
		return '<p class="inheritance-tree">' . $out . '</p>';
	}
}