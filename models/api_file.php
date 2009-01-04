<?php
/* SVN FILE: $Id$ */
/**
 * Api File Model 
 * 
 * For interacting with the Filesystem specified by ApiGenerator.filePath
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
class ApiFile extends Object {
/**
 * Name
 *
 * @var string
 */
	public $name = 'ApiFile';
/**
 * useTable
 *
 * @var string
 **/
	public $useTable = false;

/**
 * Read a path and return files and folders not in the excluded Folder list
 *
 * @param string $path The path you wish to read.
 * @return array
 **/
	public function read($path) {
		debug($path);
	}
}
?>