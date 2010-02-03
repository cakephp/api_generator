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
		$this->_text = $text;
		$out = $this->_runBlocks();
		return $out;
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
 * @return string Transformed text.
 */
	protected function _runBlocks() {
		
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