<?php

class ApiClassFixture extends CakeTestFixture {
	var $name = 'ApiClass';
	var $fields = array(
		'id' => array('type' => 'string', 'default' => NULL, 'length' => 36, 'null' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'length' => 200, 'null' => false),
		'slug' => array('type' => 'string', 'length' => 200, 'null' => false),
		'file_name' => array('type' => 'text'),
		'search_index' => array('type' => 'text'),
		'flags' => array('type' => 'integer', 'default' => 0, 'length' => 5),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime'),
	);

	var $records = array();
}