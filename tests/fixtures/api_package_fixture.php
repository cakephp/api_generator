<?php
/**
 * ApiPackage Fixture
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
 * @subpackage    api_generator.tests.fixtures
 * @since         ApiGenerator 0.5
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 **/
class ApiPackageFixture extends CakeTestFixture {
	var $name = 'ApiPackage';
	var $fields = array(
		'id' => array('type' => 'string', 'default' => NULL, 'length' => 36, 'null' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'length' => 255, 'null' => false),
		'slug' => array('type' => 'string', 'length' => 255, 'null' => false),
		'lft' => array('type' => 'integer'),
		'rght' => array('type' => 'integer'),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime')
	);

var $records = array(

);
}
?>