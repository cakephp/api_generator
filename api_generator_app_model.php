<?php
/* SVN FILE: $Id$ */
/**
 * ApiGenerator App Model class
 *
 * Base model class for models in ApiGenerator
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
class ApiGeneratorAppModel extends AppModel {
/**
 * Inflect a slashed path to url safe path. Trims ApiGenerator.filePath off as well.
 *
 * @param string $slashPath The slashed path to slug.
 * @return string
 **/
	public function slugPath($slashPath, $stripBase = true) {
		if ($stripBase) {
			$basePath = Configure::read('ApiGenerator.filePath');
			$slashPath = trim($slashPath, $basePath);
		}
		$slugPath = strtolower(Inflector::slug($slashPath, '-'));
		return $slugPath;
	}
}
?>