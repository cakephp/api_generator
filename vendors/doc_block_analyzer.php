<?php
/**
 * Docs analyzer - Uses a simple extensible rules system
 * to analzye doc block arrays and evaluate their 'goodness'
 *
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
 * @package         api_generator
 * @subpackage      api_generator.vendors
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class DocBlockAnalyzer {
/**
 * Constructed Rules objects.
 *
 * @var array
 **/
	protected $_rules = array();
/**
 * Rules classes that are going to be used
 *
 * @var array
 **/
	protected $_ruleNames = array();
/**
 * Default rules
 *
 * @var string
 **/
	protected $_defaultRules = array(
		'MissingLink', 'Empty', 'MissingParams', 'IncompleteTags'
	);
/**
 * Current reflection objects being inspected.
 *
 * @var object
 **/
	protected $_reflection;
/**
 * Constructor
 *
 * @param array $rules Names of DocBlockRule Classes you want to use.
 * @return void
 **/
	public function __construct($rules = array()) {
		if (empty($rules)) {
			$rules = $this->_defaultRules;
		}
		$this->_ruleNames = $rules;
		$this->_buildRules();
	}
/**
 * Build the rules objects
 *
 * @return void
 **/
	protected function _buildRules() {
		foreach ($this->_ruleNames as $rule) {
			$className = $rule . 'DocBlockRule';
			if (!class_exists($className, false)) {
				trigger_error('Missing Rule Class ' . $className, E_USER_WARNING);
				continue;
			}
			$rule = new $className();
			if ($rule instanceof DocBlockRule) {
				$this->_rules[] = $rule;
			}
		}
	}
/**
 * Get the Descriptions and Names of the Rules being used.
 *
 * @return array
 **/
	public function getRules() {
		$out = array();
		foreach ($this->_rules as $rule) {
			$name = get_class($rule);
			$out[$name] = $rule->description;
		}
		return $out;
	}
/**
 * Set the source for the Analyzation.  Expects either a ClassDocumentor or FunctionDocumentor instance.
 *
 * @param object $reflector Reflection Object to be inspected.
 * @return boolean Success of setting source.
 **/
	public function setSource($reflector) {
		if (!($reflector instanceof ClassDocumentor) && !($reflector instanceof FunctionDocumentor)) {
			trigger_error(sprintf(
				'Expects an instance of ClassDocumentor or FunctionDocumentor, %s was given', 
				get_class($reflector)
			), E_USER_WARNING);
			return false;
		}
		$reflector->getAll();
		$this->_reflection = $reflector;
		return true;
	}
/**
 * Analyze a Reflection object.
 * 
 * @param object $reflector Reflection Object to be inspected (optional)
 * @return array Array of scoring information
 **/
	public function analyze($reflector = null) {
		if ($reflector !== null) {
			$valid = $this->setSource($reflector);
			if (!$valid) {
				return array();
			}
		}
		
	}
}


/**
 * Abstract Base Class for DocBlock Rules
 *
 * @package api_generator.vendors.doc_block_analyzer
 **/
abstract class DocBlockRule {
/**
 * Description of the rule
 *
 * @var string
 **/
	public $description = '';
/**
 * setSubject - Set the array of doc block info to be looked at.
 * 
 * @param array $docArray Array of parsed docblock info to evaluate.
 * @return void
 **/
	public function setSubject($docArray) {
		$this->_subject = $docArray;
	}
/**
 * Score - Run the scoring system for this rule
 *
 * @access public
 * @return float Returns the float value (between 0 - 1) of the rule.
 **/
	abstract public function score();
}


/**
 * Check for missing @link tags
 *
 * @package default
 **/
class MissingLinkDocBlockRule extends DocBlockRule {
	public $description = 'Missing @link tags';
/**
 * Check for a @link tag in the tags array.
 *
 * @return float
 **/
	public function score() {

	}
}

class EmptyDocBlockRule extends DocBlockRule {
	public $description = 'Check for empty doc string';
/**
 * score method
 *
 * @return float
 **/
	public function score() {
		
	}
}

class MissingParamsDocBlockRule extends DocBlockRule {
	public $description = 'Check for any empty @param tags';
/**
 * score method
 *
 * @return float
 **/
	public function score() {
		
	}
}

class IncompleteTagsDocBlockRule extends DocBlockRule {
	public $description = 'Check for Incomplete Tag strigs.';
/**
 * score method
 *
 * @return float
 **/
	public function score() {
		
	}
}