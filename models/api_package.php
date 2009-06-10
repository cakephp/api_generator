<?php
/**
 * ApiPackage Model Works with Package Strings in the API docs
 *
 * 
 *
 * PHP versions 4 and 5
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
 * @subpackage    api_generator.models
 * @since         ApiGenerator v 0.5
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class ApiPackage extends ApiGeneratorAppModel {
/**
 * name
 *
 * @var string
 **/
	public $name = 'ApiPackage';

/**
 * actsAs
 *
 * @var array
 **/
	public $actsAs = array(
		'Tree'
	);

/**
 * hasMany assocs
 *
 * @var array
 **/
	public $hasMany = array(
		'ApiClass' => array(
			'className' => 'ApiGenerator.ApiClass',
			'foreignKey' => 'api_package_id',
		)
	);

/**
 * get the package index tree.
 *
 * @return array Array of nested packages.
 **/
	public function getPackageIndex() {
		return $this->find('threaded', array(
			'recursive' => -1
		));
	}
}