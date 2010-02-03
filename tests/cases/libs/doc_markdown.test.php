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
 * end test
 *
 * @return void
 */
	function endTest() {
		unset($this->Parser);
	}
}