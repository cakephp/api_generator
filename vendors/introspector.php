<?php
/* SVN FILE: $Id$ */
/**
 * Introspector Introspect stuff
 *
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
 * @subpackage      cake.api_generator.vendors
 * @since           
 * @version         
 * @modifiedby      
 * @lastmodified    
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Introspector provides factory methods and common methods for
 * reflection parsing
 *
 * @package cake.api_generator.vendors
 */
class Introspector {
/**
 * reflector classMappings
 *
 * @var array
 **/
	protected static $_reflectorMap = array(
		'class' => 'ClassDocumentor',
		'function' => 'FunctionDocumentor',
	);
/**
 * Get the correct reflector type for the requested object
 *
 * @param string $type The type of reflector needed
 * @param string $name The name of the function/class being reflected
 * @return object constructed reflector type.
 * @throws Exception
 */
	public static function getReflector($type, $name = null) {
		if ($name === null) {
			$name = $type;
			$type = 'class';
		}
		if (!isset(self::$_reflectorMap[$type])) {
			throw new Exception('Missing reflector mapping type');
		}
		if (!class_exists(self::$_reflectorMap[$type])) {
			$reflectorName = 'ApiGenerator.' . self::$_reflectorMap[$type];
			App::import('Vendor', $reflectorName);
		}
		return new self::$_reflectorMap[$type]($name);
	}
/**
 * parseDocBlock
 *
 * Cleans input comments of stars and /'s so it is more readable.
 * Creates a multi dimensional array. That contains semi parsed comments
 * 
 * Returns an array with the following
 * 'title' contains the title / first line of the doc-block
 * 'desc' contains the remainder of the doc block
 * 'tags' contains all the doc-blocks @tags.
 * 
 * @param string $comments The comment block to be cleaned
 * @return array Array of Filtered and separated comments
 **/
	public static function parseDocBlock($comments){
		$com = array();

		//remove stars and slashes
		$tmp = preg_replace('#^(\s*/\*\*|\s*\*+/|\s+\* ?)#m', '', $comments);

		//fix new lines
		$tmp = str_replace("\r\n", "\n", $tmp);
		$tmp = explode("\n", $tmp);

		$desc = '';	
		$tags = array();
		for ($i = 0, $count = count($tmp); $i < $count; $i++ ) {
			$line = $tmp[$i];
			if (substr($line, 0, 1) !== '@' && $line !== '*') {
				$desc .= "\n" . $line;
			}
			if (preg_match('/@([a-z0-9_-]+)\s(.*)$/i', $tmp[$i], $parsedTag)) {
				if (isset($tags[$parsedTag[1]]) && !is_array($tags[$parsedTag[1]])) {
					$tags[$parsedTag[1]] = (array)$tags[$parsedTag[1]];
					$tags[$parsedTag[1]][] = $parsedTag[2];
				} elseif (isset($tags[$parsedTag[1]]) && is_array($tags[$parsedTag[1]])) {
					$tags[$parsedTag[1]][] = $parsedTag[2];
				} else {
					$tags[$parsedTag[1]] = $parsedTag[2];
				}
			}

		}
		if (isset($tags['param'])) {
			$params = (array)$tags['param'];
			$tags['param'] = array();
			foreach ($params as $param) {
				$paramDoc = explode(' ', $param, 3);
				switch (count($paramDoc)) {
					case 2:
						list($type, $name) = $paramDoc;
						break;
					case 3:
						list($type, $name, $description) = $paramDoc;
						break;
				}
				$name = @trim($name, '$');
				$tags['param'][$name] = compact('type', 'description');
			}
		}
		$com['description'] = trim($desc);
		$com['tags'] = $tags;
		return $com;
	}
/**
 * Create a string representation of the method signature.
 *
 * @param ReflectionFunctionAbstract $func The function you want a signature for.
 * @return void
 **/
	public static function makeFunctionSignature(ReflectionFunctionAbstract $func ) {
		$signature = $func->getName() . '( ';
		foreach ($func->getParameters() as $param) {
			$signature .= '$' . $param->getName();
			if ($param->isDefaultValueAvailable()) {
				$signature .= ' = ' . $param->getDefaultValue();
			}
			$signature .= ', ';
		}
		if ($func->getNumberOfParameters() > 0) {
			$signature = substr($signature, 0, -2);
		}
		$signature .= ' )';
		return $signature;
	}
}