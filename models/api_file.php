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
 * A list of folders to ignore.
 *
 * @var array
 **/
	public $ignoreFolders = array('config', 'webroot', 'tmp', 'locale');
/**
 * A list of files to ignore.
 *
 * @var array
 **/
	public $ignoreFiles = array('index.php');
/**
 * a list of extensions to scan for
 *
 * @var array
 **/
	public $extensionsToScan = array('php');
/**
 * A regexp for file names. (will be made case insenstive)
 *
 * @var string
 **/
	public $fileRegExp = '[a-z_\-0-9]+';
/**
 * Folder instance
 *
 * @var Folder
 **/
	protected $_Folder;
/**
 * Constructor
 *
 * @return void
 **/
	public function __construct() {
		parent::__construct();
		$this->_Folder = new Folder(Configure::read('ApiGenerator.filePath'));
	}
/**
 * Read a path and return files and folders not in the excluded Folder list
 *
 * @param string $path The path you wish to read.
 * @return array
 **/
	public function read($path) {
		$this->_Folder->cd($path);
		$filePattern =  $this->fileRegExp . '\.' . implode('|', $this->extensionsToScan);
		$ignore = $this->ignoreFiles;
		$ignore[] = '.';
		$contents = $this->_Folder->read(true, $ignore);
		$this->_filterFiles($contents[0], false);
		return $contents;
	}
/**
 * _filterFiles
 * 
 * Filter a file list and remove ignoreFolders
 * 
 * @param array $files List of files to filter and ignore. (reference)
 * @return void
 **/
	protected function _filterFiles(&$fileList, $recursiveList = true) {
		$count = count($fileList);
		foreach ($this->ignoreFolders as $blackListed) {
			if ($recursiveList) {
				$blackListed = DS . $blackListed . DS;
			}
			for ($i = 0; $i < $count; $i++) {
				if (isset($fileList[$i]) && strpos($fileList[$i], $blackListed) !== false) {
					unset($fileList[$i]);
				}
			}
		}
		$fileList = array_values($fileList);
	}
}
?>