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
 * Flag bitmask for Pseudo classes (files with global functions)
 * get a pseudo class assigned to them
 *
 * @var int
 **/
	const PSEUDO_CLASS = 1;
/**
 * Concrete class bitmask;
 *
 * @var string
 **/
	const CONCRETE_CLASS = 0;
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
/**
 * Save a set of global functions to the ApiClass index.
 * Will make one record with a 'class name' derived from the filename.
 *
 * @param array $functions Array of FunctionDocumentor objects to index.
 * @param string $filename Name of file these things are found in.
 * @return boolean
 **/
	public function savePseudoClassDocs($functions, $filename) {
		$methodList = array();
		$name = basename($filename);
		$slug = str_replace('_', '-', Inflector::underscore($name));
		foreach ($functions as $func) {
			if ($func instanceof FunctionDocumentor) {
				$methodList[] = $func->getName();
			}
		}
		$data = array(
			'name' => $name,
			'slug' => $slug,
			'file_name' => $filename,
			'method_index' => implode($methodList, ' '),
			'flags' => ApiClass::PSEUDO_CLASS,
		);
		$this->set($data);
		return $this->save();
	}
/**
 * search method
 *
 * Find matching records for the given term or terms
 * Find results ordered by those matching in order: class names, method names, properties
 *
 * @param mixed $terms array of terms or search term
 * @return array of matching ApiFile objects
 * @access public
 */
	function search($terms = array()) {
		if (!$terms) {
			return array();
		}
		$terms = array_map('strtolower', (array)$terms);
		$fields = array('DISTINCT ApiClass.id', 'ApiClass.name', 'ApiClass.method_index',
			'ApiClass.property_index', 'file_name');
		$order = 'ApiClass.name';

		$conditions = array();
		foreach ($terms as $term) {
			$conditions['OR'][] = array('ApiClass.slug LIKE' => $term . '%');
			$conditions['OR'][] = array('ApiClass.method_index LIKE' => '%' . $term . '%');
			$conditions['OR'][] = array('ApiClass.property_index LIKE' => '%' . $term . '%');
		}
		$results = $this->find('all', compact('conditions', 'order', 'fields'));
		return $this->_queryFiles($results, $terms);
	}

/**
 * Get the class index listing
 * 
 * @param boolean $includePseudoClass Whether you want to include 'pseudo' classes (no actual class)
 * @return array
 **/
	public function getClassIndex($includePseudoClass = false) {
		$conditions = array();
		if (!$includePseudoClass) {
			$conditions['ApiClass.flags'] = ApiClass::CONCRETE_CLASS;
		}
		return $this->find('list', array(
			'fields' => array('slug', 'name'), 
			'order' => 'ApiClass.name ASC',
			'conditions' => $conditions
		));
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
/**
 * filterSearchResults method
 *
 * Purge results that don't match the search terms
 *
 * @param array $results
 * @param array $terms
 * @return array filtered results
 * @access protected
 */
	protected function _queryFiles($results, $terms) {
		$return = $_return = array();
		$ApiFile =& ClassRegistry::init('ApiGenerator.ApiFile');
		foreach ($results as $i => $result) {
			$result = $ApiFile->loadFile($result['ApiClass']['file_name'], array('useIndex' => true));
			foreach ($result['class'] as $name => $obj) {
				$relevance = 0;
				$this->_unsetUnmatching($obj, $terms, 'properties');
				$this->_unsetUnmatching($obj, $terms, 'methods');
				foreach ($terms as $term) {
					if (low($name) ===  $term) {
						$relevance += 6;
					} elseif (strpos(low($name), $term) === 0) {
						$relevance += 3;
					}
				}
				if ($obj->methods) {
					foreach ($obj->methods as $method) {
						$_name = strtolower($method['name']);
						foreach ($terms as $term) {
							if ($_name === $term) {
								$relevance += 4;
							} elseif (strpos($_name, $term) === 0) {
								$relevance += 2;
							}
						}
					}
				}
				if ($obj->properties) {
					foreach ($obj->properties as $property) {
						$_name = strtolower($property['name']);
						foreach($terms as $term) {
							if ($_name === $term) {
								$relevance += 4;
							} elseif (strpos($_name, $term) === 0) {
								$relevance += 2;
							}
						}
					}
				}
				if ($relevance > 0) {
					$_return[$relevance][$name]['class'][$name] = $obj;
				}
			}
			foreach ($result['function'] as $name => $obj) {
				$relevance = 0;
				foreach ($terms as $term) {
					if (low($name) ===  $term) {
						$relevance += 6;
					} elseif (strpos(low($name), $term) === 0) {
						$relevance += 3;
					}
					if ($relevance > 0) {
						$_return[$relevance][$name]['function'][$name] = $obj;
					}
				}
			}
		}
		ksort($_return);
		$_return = array_reverse($_return);
		foreach ($_return as $result) {
			ksort($result);
			$return = am($return, $result);
		}
		return $return;
	}
/**
 * unsetUnmatching method
 *
 * @param mixed $obj
 * @param array $terms
 * @param string $field
 * @return void
 * @access protected
 */
	function _unsetUnmatching(&$obj, $terms = array(), $field = 'properties') {
		if (empty($obj->$field)) {
			return;
		}
		foreach ($obj->$field as $j => $prop) {
			$delete = true;
			foreach($terms as $term) {
				if (strpos(strtolower($prop['name']), $term) !== false) {
					$delete = false;
					break;
				}
			}
			if ($delete) {
				unset ($obj->{$field}[$j]);
			}
		}
	}
}
?>