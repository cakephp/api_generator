<?php
/**
 * Api Doc Helper Test
 *
 * PHP 5.2+
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org
 * @package       api_generator
 * @subpackage    api_generator.tests.helpers
 * @since         ApiGenerator 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 **/
App::import('Core', array('View', 'Controller'));
App::import('Helper', array('ApiGenerator.ApiDoc', 'Html'));

/**
* ApiDocHelper test case
*/
class ApiDocHelperTestCase extends CakeTestCase {
/**
 * startTest
 *
 * @return void
 **/
	function startTest() {
		$this->_pluginPath = dirname(dirname(dirname(dirname(__FILE__))));
		$controller = new Controller();
		$view = new View($controller);
		$view->set('basePath', $this->_pluginPath);
		$this->ApiDoc = new ApiDocHelper();
		$this->ApiDoc->Html = new HtmlHelper();
	}
/**
 * test inBasePath
 *
 * @return void
 **/
	function testInBasePath() {
		$this->assertFalse($this->ApiDoc->inBasePath('/some/random/path'));
		$this->assertTrue($this->ApiDoc->inBasePath(__FILE__));
	}
/**
 * undocumented function
 *
 * @return void
 **/
	function testTrimFileName() {
		$result = $this->ApiDoc->trimFileName($this->_pluginPath . '/tests/cases/helpers/api_doc.test.php');
		$this->assertEqual($result, '/tests/cases/helpers/api_doc.test.php');
	}
/**
 * testFileLink
 *
 * Test file link / no link based on base path of file.
 *
 * @return void
 **/
	function testFileLink() {
		$result = $this->ApiDoc->fileLink('/foo/bar');
		$this->assertEqual($result, '/foo/bar');

		$testFile = $this->_pluginPath . '/views/helpers/api_doc.php';

		$result = $this->ApiDoc->fileLink($testFile);
		$expected = array(
			'a' => array('href' => '/api_generator/view_file/views/helpers/api_doc.php'),
			'preg:/\/views\/helpers\/api_doc.php/',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->ApiDoc->fileLink($testFile, array('controller' => 'foo', 'action' => 'bar'));
		$expected = array(
			'a' => array('href' => '/api_generator/foo/bar/views/helpers/api_doc.php'),
			'preg:/\/views\/helpers\/api_doc.php/',
			'/a'
		);
		$this->assertTags($result, $expected);
	}
/**
 * endTest
 *
 * @return void
 **/
	function endTest() {
		ClassRegistry::flush();
		unset($this->ApiDoc);
	}
}
