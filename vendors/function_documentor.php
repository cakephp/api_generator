<?php
/* SVN FILE: $Id$ */
/**
 * Function Documentor Class
 *
 * Used for parsing and extracting documentation and introspecting on functions
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
 * @subpackage      cake.api_generator.vendors
 * @since           
 * @version         
 * @modifiedby      
 * @lastmodified    
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Vendor', 'ApiGenerator.Introspector');

class FunctionDocumentor extends ReflectionFunction {
/**
 * Information about the function
 *
 * @var array
 **/
	public $info;
/**
 * Params the function has
 *
 * @var string
 **/
	public $params;
/**
 * get General information about the function 
 * doc block, declared line/file etc.
 *
 * @return array
 **/
	public function getInfo() {
		$info = array(
			'name' => $this->getName(),
			'comment' => $this->_parseComment($this->getDocComment()),
			'declaredInFile' => $this->getFileName(),
			'startLine' => $this->getStartLine(),
			'endLine' => $this->getEndLine(),
			'internal' => $this->isInternal(), 
			'signature' => Introspector::makeFunctionSignature($this)
		);
		$this->info = $info;
		return $this->info;
	}
/**
 * Get all the information for each parameter the function has
 *
 * @return array
 **/
	public function getParameters() {
		$params = parent::getParameters();
		if (!isset($this->info['comment']['tags']['param'])) {
			$this->getInfo();
		}
		foreach ($params as $param) {
			$type = $description = null;
			if (isset($this->info['comment']['tags']['param'][$param->name])) {
				extract($this->info['comment']['tags']['param'][$param->name]);
			}
			$this->params[$param->name] = array(
				'optional' => $param->isOptional(),
				'default' => null,
				'position' => $param->getPosition(),
				'type' => $type,
				'comment' => $description
			);
			if ($param->isDefaultValueAvailable()) {
				$this->params[$param->name]['default'] = $param->getDefaultValue();
			}
		}		
		return $this->params;
	}
/**
 * getAll docs for the current function documentor
 *
 * @return object
 **/
	public function getAll() {
		$this->getInfo();
		$this->getParameters();
	}
/**
 * _parseComment
 *
 * @param string $comment Comment string to parse
 * @return string
 **/
	protected function _parseComment($comment) {
		return Introspector::parseDocBlock($comment);
	}
}