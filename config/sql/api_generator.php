<?php
/* SVN FILE: $Id$ */
/**
 * Api Generator Schema file.
 *
 * Schema file for Api Generator.
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
 * @subpackage      cake.api_generator.config
 * @since
 * @version
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * ApiGenerator Plugin Schema
 *
 * @package cake.api_generator.config
 */
class ApiGeneratorSchema extends CakeSchema {
/**
 * api_classes table definition.
 *
 * @var array
 */
	public $api_classes = array(
		'id' => array('type' => 'string', 'default' => NULL, 'length' => 36, 'null' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'length' => 200, 'null' => false),
		'slug' => array('type' => 'string', 'length' => 200, 'null' => false),
		'file_name' => array('type' => 'text'),
		'method_index' => array('type' => 'text'),
		'property_index' => array('type' => 'text'),
		'flags' => array('type' => 'integer', 'default' => 0, 'length' => 5),
		'coverage_cache' => array('type' => 'float', 'length' => '2,2'),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime'),
	);
}