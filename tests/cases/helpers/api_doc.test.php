<?php
/* SVN FILE: $Id$ */
/**
 * Api Doc Helper Test
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
 * @package         cake
 * @subpackage      cake.cake.libs.
 * @since           CakePHP v 1.2.0.4487
 * @version         
 * @modifiedby      
 * @lastmodified    
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
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
