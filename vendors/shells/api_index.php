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
 * Holds current config
 *
 * @var ApiClass
 **/
	public $config = array();
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
 * Initialize the database and insert the schema.
 *
 * @return void
 **/
	public function set_routes() {
		$Routes = new File(CONFIGS . 'routes.php');
		$new = array(
			"Router::connect('/class/*', array('plugin' => 'api_generator', 'controller' => 'api_generator', 'action' => 'view_class'));",
			"Router::connect('/file/*', array('plugin' => 'api_generator', 'controller' => 'api_generator','action' => 'view_file'));",
			"Router::connect('/:action/*', array('plugin' => 'api_generator', 'controller' => 'api_generator'), array('action' => 'classes|source|files'));",
		);

		$data = rtrim(trim($Routes->read()), "?>") . "\n\n\t" . join("\n\n\t", $new);
		if ($Routes->write($data)) {
			$this->out(__('Routes file updated'));
			return;
		}
		$this->out(__('Routes file NOT updated'));
		return;
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
		$config = $this->config();

		if (empty($config['paths'])) {
			$this->err('Config could not be found');
			return false;
		}

		$this->out('Clearing index and regenerating class index...');
		$this->ApiClass = ClassRegistry::init('ApiGenerator.ApiClass');
		$this->ApiClass->clearIndex();
		$this->ApiFile->importCoreClasses();

		foreach (array_keys($config['paths']) as $path) {
			$fileList = $this->ApiFile->fileList($path);
			foreach ($fileList as $file) {
				try {
					$docsInFile = $this->ApiFile->loadFile($file);
				} catch (Exception $e) {
					$this->err($e->getMessage());
				}
				foreach ($docsInFile['class'] as $classDocs) {
					$this->ApiClass->create();
					if ($this->ApiClass->saveClassDocs($classDocs)) {
						$this->out('Added docs for ' . $classDocs->name . ' to index');
					}
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
		$config = $this->config();

		if (empty($config['paths'])) {
			$this->err('Config could not be found');
			return false;
		}

		$this->out('The following files will be parsed when generating the API class index:');
		$this->hr();
		$this->out('');
		foreach (array_keys($config['paths']) as $path) {
			$files = $this->ApiFile->fileList($path);
			$this->_paginate($files);
		}
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
	protected function config() {
		$this->ApiConfig = ClassRegistry::init('ApiGenerator.ApiConfig');

		if (empty($this->config)) {
			$config = $this->ApiConfig->read();
			if (!empty($config)) {
				return $config;
			}
		}

		$config = array();

		$this->hr();
		$this->out('api_config.ini could not be located.');
		$this->out('Answer some questions to build it.');
		$this->hr();

		$path = null;
		while($path == null && $path != 'q') {
			$path = $this->in('Enter the path to the codebase.', '', $this->params['working']);
			if ($path[0] != '/') {
				$path = $this->params['working'] . DS . $path;
			}
			if (file_exists($path)) {
				$config['paths'][$path] = true;
			}

			$stop = $this->in('Would you like to add another path?', array('y', 'n', 'q'), 'n');
			if ($stop == 'y') {
				$path = null;
			}
		}
		$this->hr();
		$this->out('Setup some excludes');
		$this->out('excludes remove files, folders, properties and methods from the index.');
		$this->out('Input a comma separated list for multiple options');
		$this->out('to continue, just answer "n"');
		$this->hr();

		$exclude = null;
		$exclude = $this->in('Exclude properties of the following types (private, protected, static)', '', 'private');
		if ($exclude != 'q') {
			$config['exclude']['properties'] = $exclude;
		}

		$exclude = $this->in('Exclude methods of the following types (private, protected, static)', '', 'private');
		if ($exclude != 'n') {
			$config['exclude']['methods'] = $exclude;
		}

		$exclude = $this->in('Comma separated list of directories to exclude', '', 'n');
		if ($exclude != 'n') {
			$config['exclude']['directories'] = $exclude;
		}

		$exclude = $this->in('Comma separated list of files to exclude', '', 'n');
		if ($exclude != 'n') {
			$config['exclude']['files'] = $exclude;
		}

		$this->hr();
		$this->out('About the files in your codebase');
		$this->out('input a comma separated list for multiple options');
		$this->out('to continue, just answer "n"');
		$this->hr();

		$extensions = null;
		while($extensions == null && $extensions != 'n') {
			$extensions = $this->in('Extensions to parse (php, ctp, tpl)', '', 'php');
			if ($extensions != 'n') {
				$config['file']['extensions'] = $extensions;
			}
		}

		$regex = null;
		while($regex == null && $regex != 'n') {
			$regex = $this->in('Regex for matching files', '', '[a-z_\-0-9]+');
			if ($regex != 'n') {
				$config['file']['regex'] = $regex;
			}
		}

		$this->hr();
		$this->out('Do you have some classes that do not map to a filename?');
		$this->out('to continue, just answer "n"');
		$this->hr();

		$mapping = null;
		while($mapping == null && $mapping != 'n') {
			$class = $this->in('Class to map', '', 'n');
			if ($class == 'n') {
				$mapping = 'n';
			} else {
				$file = null;
				while($file == null && $file != 'n') {
					$file = $this->in('Enter the path to the file that holds ' . $class .'. this can be relative to the default path, or add a / in front to use an absolute path', '', $path);
					if ($file[0] != '/') {
						$file = $path. DS . $file;
					}
					if (file_exists($file)) {
						$mapping = true;
						$config['mappings'][$class] = $file;
					}
				}
				$stop = $this->in('Add another mapping?', array('y', 'n', 'q'), 'n');
				if ($stop == 'y') {
					$mapping = null;
				}
			}
		}

		$this->hr();
		$this->out('Usually we can find the dependencies, but ');
		$this->out('sometimes we miss. If you have files that are not generating properly');
		$this->out('Input a comma separated list for multiple options');
		$this->out('to continue, just answer "n"');
		$this->hr();

		$dependencies = null;
		while($dependencies == null && $dependencies != 'n') {
			$class = $this->in('Class with dependancies', '', 'n');
			if ($class == 'n') {
				$dependencies = 'n';
			} else {
				$parent = null;
				while($parent == null && $parent != 'n') {
					$parent = $this->in('Enter the dependencies for ' . $class, '');
					if ($parent != 'n') {
						$dependencies = true;
						$config['dependencies'][$class] = $parent;
					}
				}
				$stop = $this->in('Add another dependency?', array('y', 'n', 'q'), 'n');
				if ($stop == 'y') {
					$dependencies = null;
				}
			}
		}

		$this->hr();
		$this->out('Verify the config');
		$this->hr();
		$string = $this->ApiConfig->toString($config);
		$this->out($string);
		$this->hr();
		$looksGood = $this->in('Does the config look correct?', array('y', 'n'), 'n');

		if ($this->ApiConfig->save($string)) {
			$this->out('The config was saved');
		}
		return $this->config = $config;
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
