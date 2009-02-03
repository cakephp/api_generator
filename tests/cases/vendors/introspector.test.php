<?php

App::import('Vendor', 'ApiGenerator.Introspector');

class IntrospectorTestCase extends CakeTestCase {
/**
 * testGetReflector
 *
 * @access public
 * @return void
 */	
	function testGetReflector() {
		$result = Introspector::getReflector('function', 'substr');
		$this->assertTrue($result instanceof FunctionDocumentor);
		
		$result = Introspector::getReflector('class', 'Introspector');
		$this->assertTrue($result instanceof ClassDocumentor);
		
		$result = Introspector::getReflector('Introspector');
		$this->assertTrue($result instanceof ClassDocumentor);
	}
	
	/**
	 * test the correct parsing of comment blocks
	 *
	 * @return void
	 **/
	function testCommentParsing() {
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
		$result = Introspector::parseDocBlock($comment);
		$expected = array(
			'description' => "This is the title\n\nThis is my long description",
			'tags' => array (
				'param' => array(
					'foo' => array(
						'type' => 'string',
						'description' => 'Foo is an input',
					),
					'bar' => array(
						'type' => 'int',
						'description' => 'Bar is also an input',
					)
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
		$result = Introspector::parseDocBlock($comment);
		$expected = array(
			'description' => "This is the title\n\nThis is my long description", 
			'tags' => array (
				'param' => array(
					'foo' => array(
						'type' => 'string',
						'description' => 'Foo is an input'
					),
					'bar' => array(
						'type' => 'int',
						'description' => 'Bar is also an input',
					),
					'baz' => array(
						'type' => 'int',
						'description' => 'Baz is also an input'
					),
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
		 * @return string This is a longer doc string for the
		 *   return string.
		 */
EOD;
		$result = Introspector::parseDocBlock($comment);
		$this->assertEqual($result['tags']['return'], 'string This is a longer doc string for the return string.', 'parsing spaces failed %s');
		
		$comment = <<<EOD
		/**
		 * This is the title
		 *
		 * This is my long description
		 *
		 * @return string This is a longer doc string for the
		 *	return string.
		 */
EOD;
		$result = Introspector::parseDocBlock($comment);
		$this->assertEqual($result['tags']['return'], 'string This is a longer doc string for the return string.', 'parsing single tab failed %s');
		
		
		$comment = <<<EOD
		/**
		 * This is the title
		 *
		 * This is my long description
		 *
		 * @param string \$foo Foo is an input
		 * @param int \$bar Bar is also an input
		 * @param int \$baz Baz is also an input
		 * @return string This is a longer doc string for the
		 * 		return string.
		 */
EOD;
		$result = Introspector::parseDocBlock($comment);
		$this->assertEqual($result['tags']['return'], 'string This is a longer doc string for the', 'multiple tabs should not be allowed %s');
	}
}
?>