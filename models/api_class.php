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
			'method_index' => $this->_generateIndex($classDoc, 'methods'),
			'property_index' => $this->_generateIndex($classDoc, 'properties'),
		);
		$this->set($new);
		return $this->save();
	}
	function search($terms = array()) {
		$fields = array('DISTINCT ApiClass.id', 'ApiClass.name', 'ApiClass.method_index', 'ApiClass.property_index', 'file_name');
		$order = 'ApiClass.name';
		$conditions = array();
		foreach ($terms as $term) {
			$conditions['OR'][] = array('OR' => array(
				'ApiClass.slug LIKE' => $term . '%',
			));
		}
		$results = $this->find('all', compact('conditions', 'order', 'fields'));

		if ($results) {
			$conditions['NOT']['ApiClass.id'] = Set::extract($results, '/ApiClass/id');
		} else {
			$conditions = array();
		}

		foreach ($terms as $term) {
			$conditions['OR'][] = array(
				'ApiClass.method_index LIKE' => '% ' . $term . '%',
			);
		}
		$results = am($results, $this->find('all', compact('conditions', 'order', 'fields')));

		if ($results) {
			$conditions['NOT']['ApiClass.id'] = Set::extract($results, '/ApiClass/id');
		} else {
			$conditions = array();
		}

		foreach ($terms as $term) {
			$conditions['OR'][] = array(
				'ApiClass.property_index LIKE' => '% ' . $term . '%',
			);
		}
		$results = am($results, $this->find('all', compact('conditions', 'order', 'fields')));

		$return = array();
		$ApiFile =& ClassRegistry::init('ApiGenerator.ApiFile');
		foreach ($results as $i => $result) {
			$return[$i] = $ApiFile->loadFile($result['ApiClass']['file_name'], array('useIndex' => true));
			foreach ($return[$i]['class'] as $name => &$obj) {
				foreach ($obj->properties as $j => $prop) {
					$delete = true;
					foreach($terms as $term) {
						if (strpos($prop['name'], $term) !== false) {
							$delete = false;
							break;
						}
					}
					if ($delete) {
						unset ($obj->properties[$j]);
					}
				}
				foreach ($obj->methods as $j => $method) {
					$delete = true;
					foreach($terms as $term) {
						if (strpos($method['name'], $term) !== false) {
							$delete = false;
							break;
						}
					}
					if ($delete) {
						unset ($obj->methods[$j]);
					}
				}
				if (!$obj->methods && !$obj->properties) {
					$delete = true;
					foreach($terms as $term) {
						if (strpos(low($obj->classInfo['name']), $term) !== false) {
							$delete = false;
							break;
						}
					}
					unset($return[$i]['class']);
				}
			}
			if (!$return[$i]['function']) {
				unset ($return[$i]['function']);
			}
			if (!$return[$i]) {
				unset ($return[$i]);
			}
		}
		return $return;
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
 * Generate a search index of methods or properties for the ClassDocumentor Object
 *
 * @param mixed $classDoc
 * @param string $what
 * @return void
 * @access protected
 */
	protected function _generateIndex(&$classDoc, $what = 'methods') {
		$index = array();
		foreach ((array)$classDoc->$what as $result) {
			if ($result['declaredInClass'] != $classDoc->classInfo['name']) {
				continue;
			}
			$index[] = $result['name'];
		}
		return strtolower(implode($index, ' '));
	}
}
?>