<?php

App::import('Lib', 'ApiGenerator.DocMarkdown');

class DocMarkdownTestCase extends CakeTestCase {

/**
 * start test
 *
 * @return void
 */
	function startTest() {
		$this->Parser = new DocMarkdown();
	}

/**
 * test emphasis and bold elements.
 *
 * @return void
 */
	function testEmphasisAndBold() {
		$text = 'Normal text *emphasis text* normal *emphasis* normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <em>emphasis text</em> normal <em>emphasis</em> normal.</p>';
		$this->assertEqual($result, $expected);

		$text = 'Normal text **bold** normal *emphasis* normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <strong>bold</strong> normal <em>emphasis</em> normal.</p>';
		$this->assertEqual($result, $expected);
		
		$text = 'Normal text ***bold*** normal *emphasis* normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <strong><em>bold</em></strong> normal <em>emphasis</em> normal.</p>';
		$this->assertEqual($result, $expected);
		
		$text = 'Normal text _emphasis text_ normal _emphasis_ normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <em>emphasis text</em> normal <em>emphasis</em> normal.</p>';
		$this->assertEqual($result, $expected);

		$text = 'Normal text __bold__ normal _emphasis_ normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <strong>bold</strong> normal <em>emphasis</em> normal.</p>';
		$this->assertEqual($result, $expected);
		
		$text = 'Normal text ___bold___ normal _emphasis_ normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <strong><em>bold</em></strong> normal <em>emphasis</em> normal.</p>';
		$this->assertEqual($result, $expected);
	}

/**
 * test inline code elements.
 *
 * @return void
 */
	function testInlineCode() {
		$text = 'Normal text `code text` normal `code` normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <code>code text</code> normal <code>code</code> normal.</p>';
		$this->assertEqual($result, $expected);

		$text = 'Normal text ``code text` normal `code`` normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <code>code text` normal `code</code> normal.</p>';
		$this->assertEqual($result, $expected);
	}

/**
 * test inline code elements.
 *
 * @return void
 */
	function testAutoLink() {
		$text = 'Normal text www.foo.com normal code normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <a href="http://www.foo.com">www.foo.com</a> normal code normal.</p>';
		$this->assertEqual($result, $expected);

		$text = 'Normal text www.foo.com/page/foo:bar normal code normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <a href="http://www.foo.com/page/foo:bar">www.foo.com/page/foo:bar</a> normal code normal.</p>';
		$this->assertEqual($result, $expected);

		$text = 'Normal text http://www.foo.com normal code normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <a href="http://www.foo.com">http://www.foo.com</a> normal code normal.</p>';
		$this->assertEqual($result, $expected);
	}

/**
 * test inline links
 *
 * @return void
 */
	function testInlineLinks() {
		$text = 'Normal text [test link](http://www.foo.com) normal code normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <a href="http://www.foo.com">test link</a> normal code normal.</p>';
		$this->assertEqual($result, $expected);

		$text = 'Normal text [test link](http://www.foo.com "some title") normal code normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal text <a href="http://www.foo.com" title="some title">test link</a> normal code normal.</p>';
		$this->assertEqual($result, $expected);
	}

/**
 * test entity conversion
 *
 * @return void
 */
	function testEntityConversion() {
		$text = 'Normal < text [test link](http://www.foo.com) normal & code normal.';
		$result = $this->Parser->parse($text);
		$expected = '<p>Normal &lt; text <a href="http://www.foo.com">test link</a> normal &amp; code normal.</p>';
		$this->assertEqual($result, $expected);
	}

/**
 * Test Headings
 *
 * @return void
 */
	function testHeadings() {
		$text = <<<TEXT
# H1
## H2 ##
### heading 3
#### heading 4
##### Imbalanced ##
######## There is no heading 8
TEXT;
		$result = $this->Parser->parse($text);
		$expected = <<<HTML
<h1>H1</h1>
<h2>H2</h2>
<h3>heading 3</h3>
<h4>heading 4</h4>
<h5>Imbalanced</h5>
<h6>There is no heading 8</h6>
HTML;
		$this->assertEqual($result, $expected);
	}

/**
 * end test
 *
 * @return void
 */
	function endTest() {
		unset($this->Parser);
	}
}