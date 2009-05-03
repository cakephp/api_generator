<?php
/**
 * Api Generator Schema file.
 *
 * Schema file for Api Generator.
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
 * @subpackage    api_generator.config.sql
 * @since         ApiGenerator 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 **/
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
		'coverage_cache' => array('type' => 'float', 'length' => '4,4'),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime'),
	);
}