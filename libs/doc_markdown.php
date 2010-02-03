<?php

class DocMarkdown {

/**
 * The text being parsed.
 *
 * @var string
 */
	protected $_text = null;

/**
 * Contains a hash map of placeholders => content
 *
 * @var array
 */
	var $_placeHolders = array();

/**
 * Parses $text containing doc-markdown text and generates the correct 
 * HTML
 *
 * ### Options:
 *
 * - stripHtml - remove any HTML before parsing.
 *
 * @param string $text Text to be converted
 * @param array $options Array of options for converting
 * @return string Parsed HTML
 */
	public function parse($text, $options = array()) {
		if (!empty($options['stripHtml'])) {
			$text = strip_tags($text);
		}
		$text = str_replace("\r\n", "\n", $text);
		$text = $this->_runBlocks($text);
		return $text;
	}

/**
 * Runs the block syntax elements in the correct order.
 * The following block syntaxes are supported
 *
 * - ATX style headers
 * - Code blocks
 * - lists
 * - paragraph
 *
 * @param string $text Text to transform
 * @return string Transformed text.
 */
	protected function _runBlocks($text) {
		$text = $this->_doHeaders($text);
		$text = $this->_doParagraphs($text);
		return $text;
	}

/**
 * Run the header elements
 *
 * @param string $text Text to be transformed
 * @return string Transformed text
 */
	protected function _doHeaders($text) {
		return $text;
	}

/**
 * Create paragraphs
 *
 * @return void
 */
	protected function _doParagraphs($text) {
		$blocks = preg_split('/\n\n/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
		for ($i = 0, $len = count($blocks); $i < $len; $i++) {
			$blocks[$i] = '<p>' . $this->_runInline($blocks[$i]) . '</p>';
		}
		return implode("\n\n", $blocks);
	}

/**
 * Run the inline syntax elements against $text
 * The following Inline elements are supported:
 *
 * - em
 * - strong
 * - code
 * - inline link
 * - autolink
 * - entity encoding
 *
 * In addition two special elements are parsed by a helper class specific to the 
 * API generation being used.
 *
 * - Class::method()
 * - Class::$property
 *
 * @return string Transformed text.
 */
	protected function _runInline($text) {
		$text = $this->_doItalicAndBold($text);
		$text = $this->_doInlineCode($text);
		return $text;
	}

/**
 * Transform `*italic* and **bold**` into `<em>italic</em> and <strong>bold</strong>`
 *
 * @param string $text Text to transform
 * @return string Transformed text.
 */
	protected function _doItalicAndBold($text) {
		$boldPattern = '/(\*\*|__)(?=\S)(.+?[\*_]*)(?<=\S)\1/';
		$italicPattern = '/(\*|_)(?=\S)(.+?)(?<=\S)\1/';
		$text = preg_replace($boldPattern, '<strong>\2</strong>', $text);
		$text = preg_replace($italicPattern, '<em>\2</em>', $text);
		return $text;
	}

/**
 * Transform `text` into <code>text</code>
 *
 * @param string $text Text to transform
 * @return string Transformed text.
 */
	function _doInlineCode($text) {
		$codePattern = '/(`+)(?=\S)(.+?[`]*)(?=\S)\1/';
		return preg_replace($codePattern, '<code>\2</code>', $text);
	}

/**
 * Replace placeholders in $text with the literal values in the _placeHolders array.
 *
 * @param string $text Text to have placeholders replaced in.
 * @return string Text with placeholders replaced.
 **/
	protected function _replacePlaceHolders($text) {
		foreach ($this->_placeHolders as $marker => $replacement) {
			$replaced = 0;
			$text = str_replace($marker, $replacement, $text, $replaced);
			if ($replaced > 0) {
				unset($this->_placeHolders[$marker]);
			}
		}
		return $text;
	}

/**
 * Convert $text into a placeholder text string
 *
 * @param string $text Text to convert into a placeholder marker
 * @return string
 **/
	protected function _makePlaceHolder($text) {
		$count = count($this->_placeHolders);
		$marker = 'B0x1A' . $count;
		$this->_placeHolders[$marker] = $text;
		return $marker;
	}
}