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
 * @package         cake
 * @subpackage      cake.api_generator.controllers
 * @since           
 * @version         
 * @modifiedby      
 * @lastmodified    
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class ApiGeneratorAppController extends AppController {
/**
 * beforeFilter callback
 *
 * @return void
 **/
	public function beforeFilter() {
		$path = Configure::read('ApiGenerator.filePath');
		if (empty($path)) {
			$path = APP;
		}
		$this->path = $path;
	}
}
?>