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
		$controller = new Controller();
		$view = new View($controller);
		$view->set('basePath', '/cake/tests/');
		$this->ApiDoc = new ApiDocHelper();
		$this->ApiDoc->Html = new HtmlHelper();
	}
/**
 * test inBasePath
 *
 * @return void
 **/
	function testInBasePath() {
		$this->assertFalse($this->ApiDoc->inBasePath('/foo/bar/path'));
		$this->assertTrue($this->ApiDoc->inBasePath('/cake/tests/my/path'));
	}
/**
 * undocumented function
 *
 * @return void
 **/
	function testTrimFileName() {
		$result = $this->ApiDoc->trimFileName('/cake/tests/my/path');
		$this->assertEqual($result, 'my/path');

		$this->ApiDoc->setBasePath('/Users/markstory/Sites/cake_debug_kit/');
		$result = $this->ApiDoc->trimFileName('/Users/markstory/Sites/cake_debug_kit/controllers/posts_controller.php');
		$this->assertEqual($result, 'controllers/posts_controller.php');
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
		
		$result = $this->ApiDoc->fileLink('/cake/tests/my/path');
		$expected = array(
			'a' => array('href' => '/api_generator/view_file/my/path'),
			'my/path',
			'/a'
		);
		$this->assertTags($result, $expected);

		$result = $this->ApiDoc->fileLink('/cake/tests/my/path', array('controller' => 'foo', 'action' => 'bar'));
		$expected = array(
			'a' => array('href' => '/api_generator/foo/bar/my/path'),
			'my/path',
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
