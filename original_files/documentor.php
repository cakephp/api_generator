<?php
/**
 * Bones_Utility_Documenter
 * 
 * Provides access to ReflectionClass for all Bones_Objects. Also has easy methods for retrieving 
 * All methods, Properties or ClassInfo.  And has a documentation generator for objects as well. 
 *
 * @package Bones
 * @author Mark Story
 **/
class Bones_Helper_Documenter extends ReflectionClass
{
	private $classInfo = array();
	private $methods = array();
	private $properties = array();
	public $tplFile = 'documenter.tpl';
	private $template = null;
	
	public function __construct($name)
	{
		parent::__construct($name);
		$site = Bones_Site::getInstance();
		//check for user defined error page
		if( isset($site->config->filePath) 
		    && isset($site->config->filePath->documenterTemplateFile) 
		    && $site->config->filePath->documenterTemplateFile != ''){
			$this->tplFile = $site->config->filePath->documenterTemplateFile;
		}
	}
	
	/**
	 * getClassInfo
	 *
	 * Get Basic classInfo about the current class
	 *
	 * @return array Information about Class
	 **/
	public function getClassInfo()
	{
		$this->classInfo['name'] = $this->getName();
		$this->classInfo['fileName'] = $this->getFileName();
		
		$desc = '';
		if($this->isFinal()){
			$desc .= 'final ';
		}
		if($this->isAbstract()){
			$desc .= 'abstract ';
		}
		if($this->isInterface()){
			$desc .= 'interface ';
		}else {
			$desc .= 'class ';
		}
		$desc .= $this->getName() . ' ';
		if($this->getParentClass() ){
			$desc .= 'extends ' . $this->getParentClass()->getName();
		}
		
		$interfaces = $this->getInterfaces();
		$number = count($interfaces);
		if($number > 0){
			$desc .= ' implements ';
			foreach($interfaces as $int){
				$desc .= $int->getName() . ' ';
			}
		}	
				
		$this->classInfo['classDescription'] = $desc;
		$this->classInfo['comment'] = $this->cleanComment( $this->getDocComment() );		
		
		return $this->classInfo;
	}
	
	/**
	 * getAllProperties
	 *
	 * gets All current properties for object with documentation
	 * split by access level
	 *
	 * @return array All properties separated by access type
	 **/
	public function getAllProperties()
	{
		$properties = $this->getProperties();
		
		$public = array();
		$protected = array();
		$private = array();
		
		foreach($properties as $property){
			$name = $property->getName();
			$doc = $this->cleanComment($property->getDocComment() );
			
			$prop = array('name' => $name, 
						  'comment' => $doc);
			
			if($property->isPublic() ){
				$prop['access'] = 'public';
			}
			if($property->isPrivate() ){
				$prop['access'] = 'private';
			}
			if($property->isProtected() ){
				$prop['access'] = 'protected';
			}
			
			if($property->isStatic() ){
				$prop['access'] .= ' static';
			}
				
			$this->properties[] = $prop;
		}
		
		$static = $this->getStaticProperties();
		
		foreach($static as $prop){
			$properties[] = array('name' => $prop->getName(), 
								  'comment' => $prop->getDocComment(),
								  'access' => 'static'
								);
		}
	
		return $this->properties;
	}
	
	/**
	 * getAllMethods
	 *
	 * Gets all current methods for object with documentation. Returns an array with the following structure
	 * 'name' => name of the method
	 * 'access' => level of access to the method
	 * 'args' => array of arguments that the method takes. Args are removed from comment['tags'] as they don't need to be 					   				
	 *   		 repeated
	 * 'comment' => keyed array see cleanComment
	 *
	 * @see $this->cleanComment
	 * @return array multi-dimensional array of methods and their attributes 
	 **/
	public function getAllMethods()
	{
		$methods = $this->getMethods();
		
		foreach($methods as $method)
		{
			$name = $method->getName();
			$doc = $this->cleanComment($method->getDocComment() );
			
			$met = array('name' => $name, 
						 'comment' => $doc,
						 'args' => array()
						);
						
			$args = $method->getParameters();
			
			foreach($met['comment']['tags'] as $k => $tag){
				$tag = trim($tag);
				if(substr($tag, 0, strpos($tag, ' ', 1 ) ) == '@param' ){
					$met['args'][] = substr($tag, strpos($tag, ' ', 1 ) );
					//remove the entry from the tags 
					unset($met['comment']['tags'][$k]);
				}

			}		
				
			if($method->isPublic() ){
			
				$met['access'] = 'public';
			}
			if($method->isPrivate() ){
				
				$met['access'] = 'private';
			}
			if($method->isProtected() ){
				
				$met['access'] = 'protected';
			}
			if($method->isStatic() ){
				$met['access'] .= '-static';
			}
			$this->methods[] = $met;
		}
		
		return $this->methods;
	}
	
	/**
	* getFullDoc
	*
	* get All the objects Documentation / Notes
	* Loads a smarty Template allowing ease of reading
	* This template can be configured in the config.xml
	* 
	* @return void 
	*/
	public function getFullDoc()
	{
		$doc = array();
		
		if(count($this->classInfo) == 0){
			$doc['classInfo'] = $this->getClassInfo();
		}
		if(count($this->methods) == 0){
			$doc['methods'] = $this->getAllMethods();
		}
		if(count($this->properties) == 0){
			$doc['properties'] = $this->getAllProperties();
		}
		
		return $doc;
	}
	
	/**
	 * getDocPage
	 *
	 * Gets the controller / object documentation and switch the controller template file
	 * Called by Bones_Controller to show documentation for the current controller.
	 * Appends Data from documentation to the controller and creates a controller override template
	 * Switching controller display to show documentation results.
	 *
	 * @return void Template is change and documentation page will display.
	 **/
	public function getDocPage()
	{
		$doc = $this->getFullDoc();
		/*
		$dispatch->controller->tplFile = $this->tplFile;
		$dispatch->controller->doc = $doc;
		*/
		return $doc;
		
	}
	
	/**
	 * CleanComments
	 *
	 * Cleans input comments of stars and /'s so it is more readable.
	 * Creates a multi dimensional array. That contains semi parsed comments
	 * 
	 * 'title' contains the title / first line of the doc-block
	 * 'desc' contains all information from the title to the @tags.
	 * 'tags' contains all the doc-blocks @tags.
	 * 
	 * @param string $comments The comment block to be cleaned
	 * @return array Array of Filtered and separated comments
	 **/
	private function cleanComment($comments)
	{
		$com = array();
		//remove stars and slashes
		$tmp = str_replace('/**', '', $comments);
		$tmp = str_replace('* ', '', $tmp);
		$tmp = str_replace('*/', '', $tmp);
		$tmp = str_replace('*', '', $tmp);
		//fix new lines
		$tmp = str_replace("\r", "\n", $tmp);
		$tmp = str_replace("\n\n", "\n", $tmp);
		$tmp = str_replace("\t", "", $tmp);
		
		$tmp = explode("\n", trim($tmp));
		
		$com['title'] = $tmp[0];
		$desc = '';	
		$tags = array();
		for($i = 1; $i < count($tmp); $i++ ){
				
			if(strlen($tmp[$i]) > 0 && substr(trim($tmp[$i]), 0, 1) !== '@')
			{
				$desc .= $tmp[$i];
			}
			if(substr(trim($tmp[$i]), 0, 1) == '@'){
				$tags[] = $tmp[$i];
			}
			
		}
		$com['desc'] = trim($desc);
		$com['tags'] = $tags;
		
		return $com;
	}
	
} // END class Bones_Documenter
?>
