<?php
/* SVN FILE: $Id$ */
/**
 * Api Index generation shell
 *
 * Helps generate and maintain Api Class index.
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
 * @subpackage      cake.
 * @version         
 * @modifiedby      
 * @lastmodified    
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
* Api Index Shell
*/
class ApiIndexShell extends Shell {
/**
 * Tasks used in the shell
 *
 * @var Array
 **/
	public $tasks = array('DbConfig');
/**
 * Holds ApiClass instance
 *
 * @var ApiClass
 **/
	public $ApiClass;
/**
 * startup method
 *
 * @return void
 **/
	public function startup() {
		if ($this->command && !in_array($this->command, array('help'))) {
			if (!config('database')) {
				$this->out(__("Your database configuration was not found. Take a moment to create one.", true), true);
				$this->args = null;
				return $this->DbConfig->execute();
			}

			if (!in_array($this->command, array('initdb', 'help'))) {
				$this->ApiFile = ClassRegistry::init('ApiGenerator.ApiFile');
			}
		}
	}
/**
 * Initialize the database and insert the schema.
 *
 * @return void
 **/
	public function initdb() {
		$this->Dispatch->args = array('schema', 'run', 'create');
		$this->Dispatch->params['name'] = 'ApiGenerator';
		$this->Dispatch->params['path'] = dirname(dirname(dirname(__FILE__))) . DS. 'config' . DS . 'sql';
		$this->Dispatch->dispatch();
	}
/**
 * Main method
 *
 * @return void
 **/
	public function main() {
		return $this->help();
	}
/**
 * Update the Api Class index.
 *
 * @return void
 **/
	public function update() {
		$this->out('Clearing index and regenerating class index...');
		$this->ApiClass = ClassRegistry::init('ApiGenerator.ApiClass');
		$searchPath = Configure::read('ApiGenerator.filePath');
		if ($searchPath == null) {
			$searchPath = $this->_showFilePathWarning();
		}
		$this->ApiClass->clearIndex();
		$fileList = $this->ApiFile->fileList($searchPath);
		foreach ($fileList as $file) {
			$docsInFile = $this->ApiFile->loadFile($file);
			foreach ($docsInFile['class'] as $classDocs) {
				if ($this->ApiClass->saveClassDocs($classDocs)) {
					$this->out('Added docs for ' . $classDocs->name . ' to index');
				}
			}
		}
		$this->out('Class index Regenerated.');
	}
/**
 * Show the list of files that will be parsed.
 *
 * @return void
 **/
	public function showfiles() {
		$path = Configure::read('ApiGenerator.filePath');
		if ($path == null) {
			$path = $this->_showFilePathWarning();
		}
		$this->out('The following files will be parsed when generating the API class index:');
		$this->hr();
		$this->out('');
		$files = $this->ApiFile->fileList($path);
		$this->_paginate($files);
	}
/**
 * Pagiantion of long file lists
 *
 * @return void
 **/
	protected function _paginate($list) {
		if (count($list) > 20) {
			$chunks = array_chunk($list, 10);
			$chunkCount = count($chunks);
			$this->out(implode("\n", array_shift($chunks)));
			$chunkCount--;
			while ($chunkCount && null == $this->in('Press <return> to see next 10 files')) {
				$this->out(implode("\n", array_shift($chunks)));
				$chunkCount--;
			}
		} else {
			$this->out(implode("\n", $list));
		}
	}
/**
 * Shows a warning about default / no filePath been stored in Configure.
 *
 * @return void
 **/
	protected function _showFilePathWarning() {
		$this->out('You have not set ApiGenertor.filePath in your bootstrap.php');
		$this->out('The following dir will be used:');
		$this->hr();
		$this->out(APP);
		$this->out('');
		$response = $this->in('Do you wish to continue?', array('y', 'n'), 'n');
		if ($response == 'n') {
			$this->out("Please add Configure::write('ApiGenerator.filePath', \$path); to your bootstrap.php");
			$this->_stop();
		}
		return APP;
	}
/**
 * Get help
 *
 * @return void
 **/
	public function help() {
		$this->out('Api Generator Class Index Generation');
		$this->hr();
		$this->out('Available commands:');
		$this->out('  initdb');
		$this->out('	Create the schema used for the Api Generator Plugin');
		$this->out('  showfiles');
		$this->out('	Show the list of files that will be parsed for classes based on your configuration.');
		$this->out('	Use to check if your config is going to parse the files you want.');
		$this->out('  update');
		$this->out('	Clear the existing class index and regenerate it.');
		
	}

}
