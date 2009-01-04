<?php
/* SVN FILE: $Id$ */
/**
 * 
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
App::import('Model', 'ApiGenerator.AppModel');

class ApiGeneratorAppTestModel extends ApiGeneratorAppModel {
	public $name = 'ApiGeneratorAppTestModel';
	public $useTable = false;
	
}

class ApiGeneratorAppModelTestCase extends CakeTestCase {
/**
 * startTest
 *
 * @return void
 **/
	function startTest() {
		$this->Model = ClassRegistry::init('ApiGeneratorAppTestModel');
	}
/**
 * test slugPath
 *
 * @return void
 **/
	function testSlugPath() {
		Configure::write('ApiGenerator.filePath', '/this/is/');
		$result = $this->Model->slugPath('/this/is/a/path/to_my/file.php');
		$expected = 'a-path-to_my-file-php';
		$this->assertEqual($result, $expected);
		
		Configure::write('ApiGenerator.filePath', '/this/is/');
		$result = $this->Model->slugPath('/this/is/a/path/to_my/f i le.php');
		$expected = 'a-path-to_my-f-i-le-php';
		$this->assertEqual($result, $expected);
		
		Configure::write('ApiGenerator.filePath', 'C:\www');
		$result = $this->Model->slugPath('C:\www\my Path\is Very Windows\file.php');
		$expected = 'my-path-is-very-windows-file-php';
		$this->assertEqual($result, $expected);
		
		Configure::write('ApiGenerator.filePath', 'C:\www');
		$result = $this->Model->slugPath('C:\www\my Path\is Very Windows\file.php', false);
		$expected = 'c-www-my-path-is-very-windows-file-php';
		$this->assertEqual($result, $expected);
	}
/**
 * endTest
 *
 * @return void
 **/
	function endTest() {
		unset($this->Model);
	}
}
?>