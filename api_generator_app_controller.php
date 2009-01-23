<?php
/* SVN FILE: $Id$ */
/**
 * Api Generator Plugin App Controller
 *
 *
 * PHP version 5
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
 * @package         api_generator
 * @subpackage      api_generator.controllers
 * @since           
 * @version         
 * @modifiedby      
 * @lastmodified    
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class ApiGeneratorAppController extends AppController {
/**
 * Use Api Layout
 *
 * @var string
 **/
	public $layout = 'api';
/**
 * beforeFilter callback
 *
 * @return void
 **/
	public function beforeFilter() {
		$this->ApiConfig = ClassRegistry::init('ApiGenerator.ApiConfig');
		$this->ApiConfig->read();
		$path = $this->ApiConfig->getPath();
		if (empty($path)) {
			$path = APP;
			$this->ApiConfig->data['paths'][$path] = true;
		}
		$path = Folder::slashTerm($path);
		$this->path = $path;
	}
/**
 * Error Generating Page.
 *
 * @return void
 **/
	protected function _notFound($name = null, $message = null) {
		$name = ($name) ? $name : 'Page Not Found';
		$message = ($message) ? $message : $this->params['url']['url'];
		$this->cakeError('error', array(
			'name' => $name,
			'message' => $message,
			'code' => 404,
			'url' => $this->params['url']['url']
		));
		$this->_stop();
	}
}
?>