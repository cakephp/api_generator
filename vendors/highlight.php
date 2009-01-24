<?php
/* SVN FILE: $Id: highlight.php 689 2008-11-05 10:30:07Z AD7six $ */

/**
 * Class to style php code as an ordered list.
 *
 * Originally from http://shiflett.org/blog/2006/oct/formatting-and-highlighting-php-code-listings
 * Some minor modifications to allow it to work with php4. 
 * Also changed:
 *  - And to add line-# anchors to each line.
 *  - Removed whitespace reductions. Caused issues with source -> highlight links
 *
 * PHP versions 4 and 5
 *
 * @filesource
 * @package       vendors
 * @since         Noswad site version 3
 * @version       $Revision: 689 $
 * @created      26/01/2007
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-11-05 11:30:07 +0100 (Wed, 05 Nov 2008) $
 */

/*
 * Default CSS to follow:
  body {
    margin: 2em;
    padding: 0;
    border: 0;
    font: 1em verdana, helvetica, sans-serif;
    color: #000;
    background: #fff;
    text-align: center;
  }
  ol.code {
    width: 90%;
    margin: 0 5%;
    padding: 0;
    font-size: 0.75em;
    line-height: 1.8em;
    overflow: hidden;
    color: #939399;
    text-align: left;
    list-style-position: inside;
    border: 1px solid #d3d3d0;
  }
  ol.code li {
    float: left;
    clear: both;
    width: 99%;
    white-space: nowrap;
    margin: 0;
    padding: 0 0 0 1%;
    background: #fff;
  }
  ol.code li.even { background: #f3f3f0; }
  ol.code li code {
    font: 1.2em courier, monospace;
    color: #c30;
    white-space: pre;
    padding-left: 0.5em;
  }
  .code .comment { color: #939399; }
  .code .default { color: #44c; }
  .code .keyword { color: #373; }
  .code .string { color: #c30; }
 */
class highlight {

	function highlight () {
		$this->__construct();
	}

	function __construct() {
		ini_set('highlight.comment', 'comment');
		ini_set('highlight.default', 'default');
		ini_set('highlight.keyword', 'keyword');
		ini_set('highlight.string', 'string');
		ini_set('highlight.html', 'html');
	}

	function process($code= "") {
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
		//$code= trim($code);

		/* Normalize Newlines */
		$code= str_replace("\r", "\n", $code);

		$lines= explode("\n", $code);
	/*	while(strip_tags($lines[count($lines) -1]) == '') {
			$lines[count($lines) -2] .= $lines[count($lines) -1];
			unset($lines[count($lines) -1]);
		}*/

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
}
?>