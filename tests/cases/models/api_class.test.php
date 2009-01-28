<?php
/* SVN FILE: $Id$ */
/**
 * ApiClass test case
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
App::import('Model', 'ApiGenerator.ApiClass');
App::import('Vendor', 'ApiGenerator.ClassDocumentor');
/**
 * ApiClassSampleClass doc block
 *
 * @package default
 */
class ApiClassSampleClass {
/**
 * foo property
 *
 * @var string
 **/
	public $foo = '';
/**
 * Test Function in Sample class
 * 
 * @param string $one First parameter
 * @param string $two Second parameter
 * @return boolean
 **/
	public function testFunct($one, $two) {

	}
/**
 * non-extended method
 * 
 * @return boolean
 **/
	public function extended() {

	}
}
/**
 * ApiClassSampleClass doc block
 *
 * @package default
 */
class ApiClassSampleClassChild extends ApiClassSampleClass {
/**
 * onlyMe
 *
 * @var string
 **/
	public $onlyMe;
/**
 * primary function
 *
 * @return void
 **/
	public function primary() {
		
	}
/**
 * extended-method this time
 * 
 * @return void
 **/
	public function extended() {

	}
}

/**
 * ApiClassTestCase
 *
 * @package api_generator.tests
 **/
class ApiFileTestCase extends CakeTestCase {
/**
 * undocumented class variable
 *
 * @var string
 **/
	var $fixtures = array('plugin.api_generator.api_class');
/**
 * startTest
 *
 * @return void
 **/
	function startTest() {
		$this->_path = APP . 'plugins' . DS . 'api_generator';
		Configure::write('ApiGenerator.filePath', $this->_path);
		$this->ApiClass = ClassRegistry::init('ApiClass');
	}
/**
 * endTest
 *
 * @return void
 **/
	function endTest() {
		unset($this->ApiClass);
	}
/**
 * Test Saving of the class docs to the db.
 *
 * @return void
 **/
	function testSaveClassDocs() {
		$docs = new ClassDocumentor('ApiClassSampleClass');
		
		$result = $this->ApiClass->saveClassDocs($docs);
		$this->assertTrue($result);
		
		$result = $this->ApiClass->read();
		$now = date('Y-m-d H:i:s');
		$expected = array(
			'ApiClass' => array(
				'id' => $this->ApiClass->id,
				'name' => 'ApiClassSampleClass',
				'slug' => 'api-class-sample-class',
				'file_name' => __FILE__,
				'search_index' => 'apiclasssampleclass doc block onlyme primary function extended-method this time',
				'flags' => 0,
				'created' => $now,
				'modified' => $now,
			)	
		);
		$this->assertEqual($result, $expected);
		
		$docs = new ClassDocumentor('ApiClassSampleClassChild');
		$result = $this->ApiClass->saveClassDocs($docs);
		$this->assertTrue($result);
		$result = $this->ApiClass->read();
		$now = date('Y-m-d H:i:s');
		$expected = array(
			'ApiClass' => array(
				'id' => $this->ApiClass->id,
				'name' => 'ApiClassSampleClass',
				'slug' => 'api-class-sample-class',
				'file_name' => __FILE__,
				'search_index' => 'apiclasssampleclass doc block foo property test function in sample class first parameter second parameter',
				'flags' => 0,
				'created' => $now,
				'modified' => $now,
			)	
		);
		$this->assertEqual($result, $expected);
	}
}