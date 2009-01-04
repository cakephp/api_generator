<?php
/**
 * Documentation Extractor
 *
 * Retrieves Documentation using PHP ReflectionClass
 *
 * @package api_generator
 */
class DocumentExtractor extends ReflectionClass {
/**
 * getClassInfo
 *
 * Get Basic classInfo about the current class
 *
 * @return array Information about Class
 **/
	public function getClassInfo(){
		$this->classInfo['name'] = $this->getName();
		$this->classInfo['fileName'] = $this->getFileName();

		$desc = '';
		if ($this->isFinal()) {
			$desc .= 'final ';
		}
		if ($this->isAbstract()) {
			$desc .= 'abstract ';
		}
		if ($this->isInterface()) {
			$desc .= 'interface ';
		} else {
			$desc .= 'class ';
		}
		$desc .= $this->getName() . ' ';
		if ($this->getParentClass()) {
			$desc .= 'extends ' . $this->getParentClass()->getName();
		}

		$interfaces = $this->getInterfaces();
		$number = count($interfaces);
		if ($number > 0){
			$desc .= ' implements ';
			foreach ($interfaces as $int) {
				$desc .= $int->getName() . ' ';
			}
		}	

		$this->classInfo['classDescription'] = $desc;
		$this->classInfo['comment'] = $this->_parseComment($this->getDocComment());

		return $this->classInfo;
	}
	
/**
 * getProperties
 *
 * gets All current properties for object with documentation
 * split by access level
 *
 * @return array All properties separated by access type
 **/
	public function getProperties(){
		$public = $protected = $private = array();
		$properties = parent::getProperties();
		
		foreach ($properties as $property) {
			$name = $property->getName();
			$doc = $this->_parseComment($property->getDocComment());

			$prop = array(
				'name' => $name,
				'comment' => $doc
			);

			if ($property->isPublic()) {
				$prop['access'] = 'public';
			}
			if ($property->isPrivate()) {
				$prop['access'] = 'private';
			}
			if ($property->isProtected()) {
				$prop['access'] = 'protected';
			}
			if ($property->isStatic()) {
				$prop['access'] .= ' static';
			}
			$this->properties[] = $prop;
		}
		return $this->properties;
	}
/**
 * getMethods
 *
 * Gets all current methods for object with documentation. 
 * Returns an array with the following structure
 * 'name' => name of the method
 * 'access' => level of access to the method
 * 'args' => array of arguments that the method takes. Args are removed from comment['tags'] as they don't need to be repeated
 * 'comment' => keyed array see cleanComment
 *
 * @see $this->_parseComment
 * @return array multi-dimensional array of methods and their attributes 
 **/
	public function getMethods() {
		$methods = parent::getMethods();
		
		foreach ($methods as $method) {
			$name = $method->getName();
			$doc = $this->_parseComment($method->getDocComment());
			
			$met = array(
				'name' => $name, 
				'comment' => $doc
			);
			unset($met['comment']['tags']['param']);
			
			$params = $method->getParameters();
			$args = array();
			foreach ($params as $param) {
				$args[$param->name] = array(
					'optional' => $param->isOptional(),
					'default' => null,
					'position' => $param->getPosition(),
				);
				if ($param->isDefaultValueAvailable()) {
					$args[$param->name]['default'] = $param->getDefaultValue();
				}
			}
			$met['args'] = $args;

			if ($method->isPublic()) {
				$met['access'] = 'public';
			}
			if ($method->isPrivate()) {
				$met['access'] = 'private';
			}
			if ($method->isProtected()) {
				$met['access'] = 'protected';
			}
			if ($method->isStatic()) {
				$met['access'] .= ' static';
			}
			$this->methods[] = $met;
		}
		return $this->methods;
	}
/**
 * _parseComment
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
	protected function _parseComment($comments){
		$com = array();

		//remove stars and slashes
		$tmp = str_replace('/**', '', $comments);
		$tmp = str_replace('* ', '', $tmp);
		$tmp = str_replace('**/', '', $tmp);
		$tmp = str_replace('*/', '', $tmp);

		//fix new lines
		$tmp = str_replace("\r\n", "\n", $tmp);
		$tmp = explode("\n", trim($tmp));

		$com['title'] = $tmp[0];
		$desc = '';	
		$tags = array();
		for ($i = 1, $count = count($tmp); $i < $count; $i++ ){
			$line = trim($tmp[$i]);
			if (strlen($line) > 0 && substr($line, 0, 1) !== '@' && $line !== '*') {
				$desc .= $tmp[$i];
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
		$com['desc'] = trim($desc);
		$com['tags'] = $tags;
		return $com;
	}
}
?>