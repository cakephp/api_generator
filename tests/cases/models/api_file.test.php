<?php
/* SVN FILE: $Id$ */
/**
 * ApiFile test case
 *
 * 
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
 * @package         cake.api_generator
 * @subpackage      cake.api_generator.tests.
 * @version         
 * @modifiedby      
 * @lastmodified    
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Model', 'ApiGenerator.ApiFile');

/**
 * ApiFileTestCase
 *
 * @package api_generator.tests
 **/
class ApiFileTestCase extends CakeTestCase {
/**
 * startTest
 *
 * @return void
 **/
	function startTest() {
		$this->_path = APP . 'plugins' . DS . 'api_generator';
		Configure::write('ApiGenerator.filePath', $this->_path);
		$this->ApiFile = new ApiFile();
	}
/**
 * endTest
 *
 * @return void
 **/
	function endTest() {
		unset($this->ApiFile);
	}
/**
 * test extractor loading
 *
 * @return void
 **/
	function testLoadExtractor() {
		$this->ApiFile->loadExtractor('class', 'ApiFile');
		$result = $this->ApiFile->getExtractor();
		$this->assertTrue($result instanceof ReflectionClass);
		$this->assertEqual($result->name, 'ApiFile');
	}
/**
 * testReading files from a folder
 *
 * @return void
 **/
	function testRead() {
		$result = $this->ApiFile->read($this->_path  . DS . 'models');
		$this->assertTrue(empty($result[0]));
		$expected = array('api_class.php', 'api_file.php');
		$this->assertEqual($result[1], $expected);
		
		$this->ApiFile->ignoreFiles[] = 'api_class.php';
		$result = $this->ApiFile->read($this->_path . DS . 'models');
		$expected = array('api_file.php');
		$this->assertEqual($result[1], $expected);
		
		$this->ApiFile->ignoreFolders = array('models', 'controllers');
		$result = $this->ApiFile->read($this->_path);
		$this->assertFalse(in_array('controllers', $result[0]));
		$this->assertFalse(in_array('models', $result[0]));
		
		$this->ApiFile->allowedExtensions = array('css');
		$this->ApiFile->ignoreFolders = array('models');
		$result = $this->ApiFile->read($this->_path);
		$this->assertTrue(empty($result[1]), 'file with not allowed extension found. %s');
		$this->assertFalse(in_array('models', $result[0]), 'file in ignored folder found %s');
	}
/**
 * test the recursive file listings and the application of the filters.
 *
 * @return void
 **/
	function testRecursiveScan() {
		
	}
}