<?php
/* SVN FILE: $Id$ */
/**
 * Api Class Model
 *
 * Used for fetching information from the class index.
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
 * @subpackage      cake.api_generator.models
 * @since
 * @version
 * @modifiedby
 * @lastmodified
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class ApiClass extends ApiGeneratorAppModel {
/**
 * Name
 *
 * @var string
 */
	public $name = 'ApiClass';
/**
 * Validation rules
 *
 * @var string
 **/
	public $validate = array(
		'name' => array(
			'empty' => array(
				'rule' => 'notEmpty',
				'message' => 'Name must not be empty',
			)
		),
		'flags' => array(
			'number' => array(
				'rule' => 'numeric',
				'message' => 'Flags are numeric only',
			)
		),
	);

/**
 * Clears (truncates) the class index.
 *
 * @return void
 **/
	public function clearIndex() {
		$db = ConnectionManager::getDataSource($this->useDbConfig);
		$db->truncate($this->useTable);
	}

/**
 * save the entry in the index for a ClassDocumentor object
 *
 * @param object $classDoc Instance of ClassDocumentor to add to database.
 * @return boolean success
 **/
	public function saveClassDocs(ClassDocumentor $classDoc) {
		$classDoc->getAll();
		$slug = str_replace('_', '-', Inflector::underscore($classDoc->name));
		$new = array(
			'name' => $classDoc->name,
			'slug' => $slug,
			'file_name' => $classDoc->classInfo['fileName'],
			'search_index' => $this->_generateSearchIndex($classDoc),
		);
		$this->set($new);
		return $this->save();
	}

/**
 * Get the class index listing
 *
 * @return array
 **/
	public function getClassIndex() {
		return $this->find('list', array('fields' => array('slug', 'name'), 'order' => 'ApiClass.name ASC'));
	}

/**
 * Generate a search index from all the properties and methods
 * in a ClassDocumentor Object
 *
 * @return string
 **/
	protected function _generateSearchIndex($classDoc) {
		$index = '';
		$index .= $classDoc->classInfo['comment']['description'];
		foreach ((array)$classDoc->properties as $prop) {
			$index .= ' ' . $prop['comment']['description'];
		}
		foreach ((array)$classDoc->methods as $method) {
			$description = str_replace("\n", ' ', $method['comment']['description']);
			$index .= ' ' . $description;
			foreach ($method['args'] as $argument) {
				$index .= ' ' . $argument['comment'];
			}
		}
		return strtolower($index);
	}
}