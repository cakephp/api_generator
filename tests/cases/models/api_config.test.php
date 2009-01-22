<?php
/**
 * ApiConfig test case
 *
 *
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2006-2008, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright       Copyright 2006-2008, Cake Software Foundation, Inc.
 * @link            http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package         cake.api_generator
 * @subpackage      cake.api_generator.tests.
 * @version
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Model', 'ApiGenerator.ApiConfig');
/**
 * ApiConfigTestCase
 *
 *
 * @package api_generator.tests
 **/
/* SAMPLE
 	[paths]
	/home/cake/plugins/api_generator = true
	/home/cake/plugins/api_generator_extensions = true

	[exclude]
	properties = private
	methods = private
	classes = MyClass, MyOtherClass

	[dependencies]
	MyClass = MyBaseClass, MyInterface
	MyOtherClass = MyClass

	[mappings]
	MyClass = My_Funky_File.php
	MyOtherClass = My_Other_File.php
*/

class ApiConfigTestCase extends CakeTestCase {
/**
 * startTest
 *
 * @return void
 **/
	function startTest() {
		$this->ApiConfig = ClassRegistry::init('ApiConfig');
		$this->ApiConfig->path = TMP . 'api_config.ini';
	}
/**
 * endTest
 *
 * @return void
 **/
	function endTest() {
		$Cleanup = new File($this->ApiConfig->path);
		$Cleanup->delete();
		unset($this->ApiConfig);
	}

	function testSave() {
		$data = array(
			'[paths]',
			'/home/cake/plugins/api_generator = true',
			'[exclude]',
			'properties = private',
			'method = private',
			'[dependencies]',
			'MyClass = MyBaseClass, MyInterface',
			'[mappings]',
			'MyClass = My_Funky_File.php',
		);
		$this->assertTrue($this->ApiConfig->save($data));
		$this->assertTrue($this->ApiConfig->save(TMP . 'api_config.ini', $data));

		$data = "[paths]\n\n/home/cake/plugins/api_generator = true\n\n";
		$this->assertTrue($this->ApiConfig->save($data));
		$this->assertTrue($this->ApiConfig->save(TMP . 'api_config.ini', $data));
	}

	function testRead() {
		$data = "[paths]\n\n/home/cake/plugins/api_generator = true\n\n";
		$this->assertTrue($this->ApiConfig->save($data));

		$result = $this->ApiConfig->read();
		$this->assertEqual($result, array(
			'paths' => array(
				'/home/cake/plugins/api_generator' => true
			)
		));

		$result = $this->ApiConfig->read($data);
		$this->assertEqual($result, array(
			'paths' => array(
				'/home/cake/plugins/api_generator' => true
			)
		));

		$data = array(
			'[paths]',
			'/home/cake/plugins/api_generator = true',
		);

		$result = $this->ApiConfig->read();
		$this->assertEqual($result, array(
			'paths' => array(
				'/home/cake/plugins/api_generator' => true
			)
		));
		

		$data = "[paths]\n\n/Home/Cake/Plugins/Api_generator = true\n\n";
		$result = $this->ApiConfig->read($data);
		$this->assertEqual($result, array(
			'paths' => array(
				'/Home/Cake/Plugins/Api_generator' => true
			)
		));
	}

	function testIt() {}
}