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
 * undocumented class variable
 *
 * @var string
 **/
	protected $_defaultRules = array();
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
 * undocumented function
 *
 * @return void
 **/
	public function setSubject($reflection) {
		$this->_subject = $reflection;
	}
/**
 * Score - Run the scoring system for this rule
 *
 * @access public
 * @return float Returns the float value (between 0 - 1) of the rule.
 **/
	abstract public function score();
}