<?php
App::import('Component', 'ApiGenerator.Documentor');
/**
 * DocumentorComponentSubject
 *
 * A simple class to test ClassInfo introspection
 *
 * @package this is my package
 * @another-tag long value
 */
class DocumentorComponentSubject extends StdClass implements Countable {
/**
 * This var is protected
 *
 * @var string
 **/
	protected $_protectedVar;
/**
 * This var is public
 *
 * @var string
 **/
	public $publicVar = 'value';
/**
 * This var is public static
 *
 * @var string
 **/
	public static $publicStatic;
/**
 * count
 * 
 * Implementation of Countable interface
 *
 * @access public
 * @return integer
 */
	public function count() { }
/**
 * something
 * 
 * does something
 *
 * @param string $arg1 First arg
 * @param string $arg2 Second arg
 * @access public
 * @return integer
 */
	protected function something($arg1, $arg2 = 'file') { }
/**
 * goGo
 * 
 * does lots of cool things
 * @param string $param a parameter
 * @return void
 **/
	public static function goGo($param) { }
}

/**
 * Documentor Test Case
 *
 * @package cake.api_generator.tests
 */
class DocumentorTestCase extends CakeTestCase {
/**
 * start a test case
 *
 * @return void
 **/
	public function startTest() {
		$this->Controller = new Controller();
		$this->Documentor = new DocumentorComponent();
		$this->Documentor->initialize($this->Controller);
	}
	
/**
 * test the ClassInfo introspection
 *
 * @return void
 **/
	function testLoadClass() {
		$this->Documentor->loadClass('DocumentorComponentSubject');
		$this->assertTrue($this->Documentor->getExtractor() instanceof DocumentExtractor);
	}
/**
 * end a test case
 *
 * @return void
 **/
	public function endTest() {
		unset($this->Controller, $this->Documentor);
	}
}
?>