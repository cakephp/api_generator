<?php
/**
 * Api Packages Controller
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
 * @subpackage    api_generator.controllers
 * @since         ApiGenerator 0.5
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 **/
class ApiPackagesController extends ApiGeneratorAppController {
/**
 * Name property
 *
 * @var string
 */
	public $name = 'ApiPackages';

/**
 * Components array
 *
 * @var array
 **/
	public $components = array('RequestHandler');

/**
 * Helpers
 *
 * @var array
 **/
	public $helpers = array('ApiGenerator.ApiDoc', 'ApiGenerator.ApiUtils', 'Html', 'Javascript', 'Text');

/**
 * Index of Packages + subpackages.
 *
 * @return void
 **/
	public function index() {
		$packageIndex = $this->ApiPackage->getPackageIndex();
		$this->set('packageIndex', $packageIndex);
	}

}