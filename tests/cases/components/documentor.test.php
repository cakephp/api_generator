<?php
App::import('Component', 'ApiGenerator.Documentor');
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
 * end a test case
 *
 * @return void
 **/
	public function endTest() {
		unset($this->Controller, $this->Documentor);
	}
}
?>