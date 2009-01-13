<?php
/* SVN FILE: $Id$ */
/**
 * Function Documentor Class
 *
 * Used for parsing and extracting documentation and introspecting on functions
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
App::import('Vendor', 'ApiGenerator.Introspector');

class FunctionDocumentor extends ReflectionFunction {

/**
 * _parseComment
 *
 * @param string $comment Comment string to parse
 * @return string
 **/
	protected function _parseComment($comment) {
		return Introspector::parseDocBlock($comment);
	}
}