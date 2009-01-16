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
				$this->ApiClass = ClassRegistry::init('ApiGenerator.ApiClass');
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
		if (!$this->command || empty($this->args)) {
			return $this->help();
		}
	}
/**
 * Update the Api Class index.
 *
 * @return void
 **/
	public function update() {
		
	}
/**
 * Show the list of files that will be parsed.
 *
 * @return void
 **/
	public function showfiles() {
		
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
		$this->out('	Show the list of files that will be parsed for classes');
		
		
	}

}
