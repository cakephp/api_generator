<?php
App::import('Vendor', 'ApiGenerator.DocumentExtractor');
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
 * Test DocumentExtractor 
 * 
 * gives access to protected methods
 *
 * @package cake.api_documentor.tests
 */
class TestDocumentExtractor extends DocumentExtractor {
	function testParseComment($commentBlock) {
		return $this->_parseComment($commentBlock);
	}
}
class DocumentExtractorTestCase extends CakeTestCase {
/**
 * test the ClassInfo introspection
 *
 * @return void
 **/
	function testGetClassInfo() {
		$Docs = new TestDocumentExtractor('SimpleDocumentorSubjectClass');
		$result = $Docs->getClassInfo();
		$expected = array (
			'name' => 'SimpleDocumentorSubjectClass', 
			'fileName' => __FILE__,
			'classDescription' => 'class SimpleDocumentorSubjectClass extends stdClass implements Countable ', 
			'comment' => array ( 
				'title' => 'SimpleDocumentorSubjectClass', 
				'desc' => 'A simple class to test ClassInfo introspection', 
				'tags' => array (
					'package' => 'this is my package', 
					'another-tag' => 'long value'
				), 
			), 
		);
		$this->assertEqual($result, $expected);
		$this->assertEqual($Docs->classInfo, $expected);
	}
/**
 * test the correct parsing of comment blocks
 *
 * @return void
 **/
	function testCommentParsing() {
		$Docs = new TestDocumentExtractor('SimpleDocumentorSubjectClass');
		$comment = <<<EOD
		/**
		 * This is the title
		 *
		 * This is my long description
		 *
		 * @param string \$foo Foo is an input
		 * @param int \$bar Bar is also an input
		 * @return string
		 */
EOD;
		$result = $Docs->testParseComment($comment);
		$expected = array(
			'title' => 'This is the title', 
			'desc' => 'This is my long description', 
			'tags' => array (
				'param' => array(
					'string $foo Foo is an input',
					'int $bar Bar is also an input' 
				),
				'return' => 'string',
			),
		);
		$this->assertEqual($result, $expected);
		
		$comment = <<<EOD
		/**
		 * This is the title
		 *
		 * This is my long description
		 *
		 * @param string \$foo Foo is an input
		 * @param int \$bar Bar is also an input
		 * @param int \$baz Baz is also an input
		 * @return string
		 */
EOD;
		$result = $Docs->testParseComment($comment);
		$expected = array(
			'title' => 'This is the title', 
			'desc' => 'This is my long description', 
			'tags' => array (
				'param' => array(
					'string $foo Foo is an input',
					'int $bar Bar is also an input',
					'int $baz Baz is also an input' 
				),
				'return' => 'string',
			),
		);
		$this->assertEqual($result, $expected);
	}
/**
 * Test getting properties and their info
 *
 * @return void
 **/
	function testGetProperties() {
		$Docs = new TestDocumentExtractor('SimpleDocumentorSubjectClass');
		$result = $Docs->getProperties();
		$expected = array( 
			array(
				'name' => '_protectedVar', 
				'comment' => array(
					'title' => 'This var is protected', 
					'desc' => '', 
					'tags' => array(
						'var' => 'string'
					)
				), 
				'access' => 'protected'), 
			array(
				'name' => 'publicVar',
				'comment' => array(
					'title' => 'This var is public', 
					'desc' => '', 
					'tags' => array(
						'var' => 'string'
					)
				),
				'access' => 'public'
			), 
			array(
				'name' => 'publicStatic', 
				'comment' => array(
					'title' => 'This var is public static', 
					'desc' => '', 
					'tags' => array(
						'var' => 'string'
					)
				),
				'access' => 'public static'
			)
		);
		$this->assertEqual($result, $expected);
		$this->assertEqual($Docs->properties, $expected);
	}
/**
 * test getting of methods
 *
 * @return void
 **/
	function testGetMethods() {
		$Docs = new TestDocumentExtractor('SimpleDocumentorSubjectClass');
		$result = $Docs->getMethods();
		$expected = array(
			array(
				'name' => 'count', 
				'comment' => array(
					'title' => 'count',
					'desc' => 'Implementation of Countable interface',
					'tags' => array(
						'access' => 'public',
						'return' => 'integer'
					)
				), 
				'args' => array( ), 
				'access' => 'public'
			), 
			array(
				'name' => 'something', 
				'comment' => array(
					'title' => 'something', 
					'desc' => 'does something', 
					'tags' => array(
						'access' => 'public', 
						'return' => 'integer'
					)
				), 
				'args' => array(
					'arg1' => array( 
						'optional' => false, 
						'default' => NULL, 
						'position' => 0,
						'type' => 'string',
						'comment' => 'First arg'
					), 
					'arg2' => array(
						'optional' => true,
						'default' => 'file',
						'position' => 1,
						'type' => 'string',
						'comment' => 'Second arg'
					)
				), 
				'access' => 'protected'
			),
			array(
				'name' => 'goGo', 
				'comment' => array(
					'title' => 'goGo', 
					'desc' => 'does lots of cool things', 
					'tags' => array(
						'return' => 'void'
					)
				),
				'args' => array(
					'param' => array(
						'optional' => false,
						'default' => NULL, 
						'position' => 0,
						'type' => 'string',
						'comment' => 'a parameter'
					)
				),
				'access' => 'public static'
			)
		);
		debug($result);
		$this->assertEqual($result, $expected);
		$this->assertEqual($Docs->methods, $expected);
	}
/**
 * test getAll()
 *
 * @return void
 **/
	function testGetAll() {
		$Docs = new TestDocumentExtractor('SimpleDocumentorSubjectClass');
		$Docs->getAll();
		$this->assertFalse(empty($Docs->classInfo));
		$this->assertFalse(empty($Docs->properties));
		$this->assertFalse(empty($Docs->methods));
	}
}
?>