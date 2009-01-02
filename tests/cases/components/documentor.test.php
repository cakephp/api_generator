<?php
App::import('Component', 'ApiGenerator.Documentor');
/**
 * SimpleDocumentorSubjectClass
 *
 * A simple class to test ClassInfo introspection
 *
 * @package this is my package
 * @another-tag long value
 */
class SimpleDocumentorSubjectClass extends StdClass implements Countable {
/**
 * count
 * 
 * Implementation of Countable interface
 *
 * @access public
 * @return integer
 */
	function count() {
		return 2;
	}
} 

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

class DocumentExtractorTestCase extends CakeTestCase {
/**
 * test the ClassInfo introspection
 *
 * @return void
 **/
	function testGetClassInfo() {
		$docs = new DocumentExtractor('SimpleDocumentorSubjectClass');
		$result = $docs->getClassInfo();
		$expected = array (
			'name' => 'SimpleDocumentorSubjectClass', 
			'fileName' => __FILE__,
			'classDescription' => 'class SimpleDocumentorSubjectClass extends stdClass implements Countable ', 
			'comment' => array ( 
				'title' => 'SimpleDocumentorSubjectClass', 
				'desc' => 'A simple class to test ClassInfo introspection', 
				'tags' => array (
					' @package this is my package', 
					' @another-tag long value'
				), 
			), 
		);
		$this->assertEqual($result, $expected);
	}
}
?>