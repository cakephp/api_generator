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
 *  - test ignored files
 *  - test ignored folders
 *  - test extensions
 *
 * @return void
 **/
	function testRead() {
		$result = $this->ApiFile->read($this->_path  . DS . 'models');
		$this->assertTrue(empty($result[0]));
		$expected = array('api_config.php', 'api_class.php', 'api_file.php');
		$this->assertEqual(sort($result[1]), sort($expected));
		
		$this->ApiFile->excludeFiles[] = 'api_class.php';
		$result = $this->ApiFile->read($this->_path . DS . 'models');
		$expected = array('api_config.php', 'api_file.php');
		$this->assertEqual($result[1], $expected);
		
		$this->ApiFile->excludeFolders = array('models', 'controllers');
		$result = $this->ApiFile->read($this->_path);
		$this->assertFalse(in_array('controllers', $result[0]));
		$this->assertFalse(in_array('models', $result[0]));
		
		$this->ApiFile->allowedExtensions = array('css');
		$this->ApiFile->excludeFolders = array('models');
		$result = $this->ApiFile->read($this->_path);
		$this->assertTrue(empty($result[1]), 'file with not allowed extension found. %s');
		$this->assertFalse(in_array('models', $result[0]), 'file in ignored folder found %s');
	}
/**
 * test file list generation
 *  - test folder exclusion
 *  - test extension permission
 *  - test file regex
 *
 * @return void
 **/
	function testGetFileList() {
		$this->ApiFile->excludeFolders = array('config', 'webroot');
		$result = $this->ApiFile->fileList(APP);
		$core = CONFIGS . 'core.php';
		$vendorJs = WWW_ROOT . 'js' . DS . 'vendors.php';
		$this->assertFalse(in_array($core, $result));
		$this->assertFalse(in_array($vendorJs, $result));
		
		$this->ApiFile->excludeFolders = array();
		$this->ApiFile->allowedExtensions = array('css');
		$result = $this->ApiFile->fileList(APP);
		$core = CONFIGS . 'core.php';
		$vendorJs = WWW_ROOT . 'js' . DS . 'vendors.php';
		$this->assertFalse(in_array($core, $result));
		$this->assertFalse(in_array($vendorJs, $result));
		
		$this->ApiFile->excludeFolders = array();
		$this->ApiFile->allowedExtensions = array('css');
		$result = $this->ApiFile->fileList(APP);
		$core = CONFIGS . 'core.php';
		$vendorJs = WWW_ROOT . 'js' . DS . 'vendors.php';
		$this->assertFalse(in_array($core, $result));
		$this->assertFalse(in_array($vendorJs, $result));
		
		$this->ApiFile->excludeFolders = array();
		$this->ApiFile->allowedExtensions = array('php');
		$this->ApiFile->removeFiles = array('index.php');
		$this->ApiFile->fileRegExp = '[a-z_0-9]+';
		$result = $this->ApiFile->fileList(APP);
		$core = CONFIGS . 'core.php';
		$index = APP . 'index.php';
		$this->assertTrue(in_array($core, $result));
		$this->assertFalse(in_array($index, $result));
	}
/**
 * test Processed docs retrieval
 *
 * @return void
 **/
	function testGetDocs() {
		$result = $this->ApiFile->getDocs();
		$this->assertTrue(empty($result));
		
		$this->ApiFile->loadExtractor('class', 'ApiFile');
		$result = $this->ApiFile->getDocs();
		$this->assertTrue($result instanceof ClassDocumentor);
		$this->assertTrue(isset($result->classInfo));
	}
/**
 * test loadFile() on a file that has already been included once
 *
 * @return void
 **/
	function testLoadFileOnAlreadyIncludedFile() {
		$result = $this->ApiFile->loadFile(__FILE__);
		$this->assertTrue(isset($result['class']));
		$this->assertTrue(isset($result['function']));
		$this->assertTrue($result['class'][__CLASS__] instanceof ClassDocumentor);
		
		$result = $this->ApiFile->loadFile(APP . 'plugins' . DS . 'api_generator' . DS . 'models' . DS . 'api_class.php');
		$this->assertTrue(isset($result['class']));
		$this->assertTrue(isset($result['function']));
		$this->assertTrue($result['class']['ApiClass'] instanceof ClassDocumentor);
	}
}