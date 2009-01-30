<?php
/* SVN FILE: $Id$ */
/**
 * Class to style php code as an ordered list.
 *
 * Originally from http://shiflett.org/blog/2006/oct/formatting-and-highlighting-php-code-listings
 * 
 * Adapted into a helper for use in ApiGenerator
 * Some minor modifications to allow it to work with php4. 
 * 
 * Also changed:
 *  - And to add line-# anchors to each line.
 *  - Removed whitespace reductions. Caused issues with source -> highlight links
 *
 * PHP versions 4 and 5
 *
 * @filesource
 * @package       api_generator.helpers
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-11-05 11:30:07 +0100 (Wed, 05 Nov 2008) $
 */
class ApiUtilsHelper extends AppHelper {
/**
 * constructor
 *
 * @return void
 **/
	function __construct() {
		ini_set('highlight.comment', 'comment');
		ini_set('highlight.default', 'default');
		ini_set('highlight.keyword', 'keyword');
		ini_set('highlight.string', 'string');
		ini_set('highlight.html', 'html');
	}

/**
 * highlights code so it can be displayed
 *
 * @param string $code Code to highlight.
 * @return string
 **/
	function highlight($code= "") {
		$code= highlight_string($code, TRUE);
		/* Clean Up */
		if (phpversion() >= 5) {
			$code= substr($code, 33, -15);
			$code= str_replace('<span style="color: ', '<span class="', $code);
		} else {
			$code= substr($code, 25, -15);
			$code= str_replace('<font color=', '<span class=', $code);
			$code= str_replace('</font>', '</span>', $code);
		}
		$code= str_replace('&nbsp;', ' ', $code);
		$code= str_replace('&amp;', '&#38;', $code);
		$code= str_replace('<br />', "\n", $code);

		/* Normalize Newlines */
		$code= str_replace("\r", "\n", $code);

		$lines= explode("\n", $code);

		/* Previous Style */
		$previous= FALSE;

		/* Output Listing */
		$return= "  <ol class=\"code\">\n";
		foreach ($lines as $key => $line) {
			if (substr($line, 0, 7) == '</span>') {
				$previous= FALSE;
				$line= substr($line, 7);
			}

			if (empty ($line)) {
				$line= '&#160;';
			}

			if ($previous) {
				$line= "<span class=\"$previous\">" . $line;
			}

			/* Set Previous Style */
			if (strpos($line, '<span') !== FALSE) {
				switch (substr($line, strrpos($line, '<span') + 13, 1)) {
					case 'c' :
						$previous= 'comment';
						break;
					case 'd' :
						$previous= 'default';
						break;
					case 'k' :
						$previous= 'keyword';
						break;
					case 's' :
						$previous= 'string';
						break;
				}
			}

			/* Unset Previous Style Unless Span Continues */
			if (substr($line, -7) == '</span>') {
				$previous= FALSE;
			}
			elseif ($previous) {
				$line .= '</span>';
			}
			$lineno = $key + 1;
			if ($key % 2) {
				$return .= "    <li class=\"even\"><a id=\"line-$lineno\"></a><code>$line</code></li>\n";
			} else {
				$return .= "    <li><a id=\"line-$lineno\"></a><code>$line</code></li>\n";
			}
		}
		$return .= "  </ol>\n";
		return $return;
	}
/**
 * Sort a collection of arrays by the key 'name'
 *
 * @param array $collection Reference to the array needing sorting.
 * @return void works by reference
 **/
	public function sortByName(&$collection) {
		if (!is_array($collection)) {
			return;
		}
		return usort($collection, array($this, '_sorter'));
	}
/**
 * sortByName helper function
 *
 * @return integer
 **/
	protected function _sorter($one, $two) {
		$cleanOne = str_replace('_', '', $one['name']);
		$cleanTwo = str_replace('_', '', $two['name']);
		return strnatcasecmp($cleanOne, $cleanTwo);
	}
}