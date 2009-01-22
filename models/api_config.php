<?php
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
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright       Copyright 2006-2008, Cake Software Foundation, Inc.
 * @link            http://cakephp.org CakePHP Project
 * @package         cake
 * @subpackage      cake.cake.libs.
 * @since           CakePHP v 1.2.0.4487
 * @version
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class ApiConfig extends Object {
/**
 * holds data for read
 *
 * @var string
 **/
	public $data = array();
/**
 * holds path to current config file
 *
 * @var string
 **/
	public $path = null;

/**
 * Constructor
 *
 * @return void
 *
 **/
	public function __construct() {
		$this->path = CONFIGS . 'api_config.ini';
	}
/**
 * Read from config file or passed array
 *
 * @param mixed $lines absolute file path, array, or string
 * @return array
 *
 **/
	public function read($lines = array()) {
		if (empty($lines)) {
			if (!empty($this->data)) {
				return $this->data;
			}
			$lines = $this->path;
		}

		if (is_string($lines)) {
			if ($lines[0] == '/') {
				$lines = file($lines);
			} else {
				$lines = explode("\n", $lines);
			}
		}
		$ini = array();

		foreach (array_filter($lines) as $line) {
			$row = trim($line);
			if (empty($row) || $row[0] == ';') {
				continue;
			}

			if ($row[0] == '[' && substr($row, -1, 1) == ']') {
				$section = preg_replace('/[\[\]]/', '', $row);
			} else {
				$delimiter = strpos($row, '=');
				if ($delimiter > 0) {
					$key = strtolower(trim(substr($row, 0, $delimiter)));
					$value = trim(substr($row, $delimiter + 1));

					if (substr($value, 0, 1) == '"' && substr($value, -1) == '"') {
						$value = substr($value, 1, -1);
					}
					$ini[$section][$key] = stripcslashes($value);
				} else {
					if (!isset($section)) {
						$section = '';
					}
					$ini[$section][strtolower(trim($row))] = '';
				}
			}
		}

		return $this->data = $ini;
	}
/**
 * Save a config
 *
 * @param mixed $path
 * @param mixed $string
 *
 * @return boolean
 *
 **/
	public function save($path = null, $string = null) {
		if (empty($path) && empty($string)) {
			return false;
		}

		if (!empty($path) && empty($string)) {
			$string = $path;
			$path = $this->path;
		}

		if (is_array($string)) {
			$string = join("/n", $string);
		}

		$File = new File($path, true, 0755);
		if ($File->write($string)) {
			return true;
		}
	}
}
?>