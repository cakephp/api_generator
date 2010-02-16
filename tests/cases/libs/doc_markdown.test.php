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
 * test horizontal rules.
 *
 * @return void
 */
	function testHorizontalRule() {
		$expected = <<<HTML
<p>this is some</p>

<hr />

<p>text</p>
HTML;

		foreach (array('-', '*', '_') as $char) {
			$text = <<<TEXT
this is some
{$char}{$char}{$char}
text
TEXT;
			$result = $this->Parser->parse($text);
			$this->assertEqual($result, $expected);

			$text = <<<TEXT
this is some
{$char}  {$char}  {$char}
text
TEXT;
			$result = $this->Parser->parse($text);
			$this->assertEqual($result, $expected);

			$text = <<<TEXT
this is some
{$char}{$char}{$char}{$char}{$char}{$char}
text
TEXT;
			$result = $this->Parser->parse($text);
			$this->assertEqual($result, $expected);
		}
	}

/**
 * test multiline code blocks
 *
 * @return void
 */
	function testCodeBlockWithDelimiters() {
		$text = <<<TEXT
this is some
@@@
function test() {
	echo '<test>';
}
@@@
more text
TEXT;
		$expected = <<<HTML
<p>this is some</p>

<pre><code>function test() {
    echo '&lt;test&gt;';
}</code></pre>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		$this->assertEqual($result, $expected);

		$text = <<<TEXT
this is some
{{{
function test() {
	echo '<test>';
}
}}}
more text
TEXT;
		$expected = <<<HTML
<p>this is some</p>

<pre><code>function test() {
    echo '&lt;test&gt;';
}</code></pre>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		$this->assertEqual($result, $expected);
	}

/**
 * test indented code blocks
 *
 * @return void
 */
	function testCodeBlockWithIndents() {
		$text = <<<TEXT
this is some

	function test() {
		echo '<test>';
	}

more text
TEXT;
		$expected = <<<HTML
<p>this is some</p>

<pre><code>function test() {
    echo '&lt;test&gt;';
}</code></pre>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		$this->assertEqual($result, $expected);

		$text = <<<TEXT
this is some

    function test() {
    	echo '<test>';
    }

more text
TEXT;
		$expected = <<<HTML
<p>this is some</p>

<pre><code>function test() {
    echo '&lt;test&gt;';
}</code></pre>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		$this->assertEqual($result, $expected);

		$text = <<<TEXT
this is some

    function test() {
    	echo '<test>';
    }
    
    \$foo->bar();

more text
TEXT;
		$expected = <<<HTML
<p>this is some</p>

<pre><code>function test() {
    echo '&lt;test&gt;';
}

\$foo-&gt;bar();</code></pre>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		$this->assertEqual($result, $expected);
	}

/**
 * Test simple ordered list parsing
 *
 * @return void
 */
	function testSimpleOrderedList() {
		$text = <<<TEXT
Some text here.

 - Line 1
 - Line 2
 - Line 3

more text
TEXT;

		$expected = <<<HTML
<p>Some text here.</p>

<ul>
<li>Line 1</li>
<li>Line 2</li>
<li>Line 3</li>
</ul>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		$this->assertEqual($result, $expected);

		$text = <<<TEXT
Some text here.

 - Line `with code`
 + Line 2
 * Line **bold**

more text
TEXT;

		$expected = <<<HTML
<p>Some text here.</p>

<ul>
<li>Line <code>with code</code></li>
<li>Line 2</li>
<li>Line <strong>bold</strong></li>
</ul>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		$this->assertEqual($result, $expected);
	}

/**
 * Test simple ordered list parsing
 *
 * @return void
 */
	function testSimpleUnorderedList() {
		$text = <<<TEXT
Some text here.

 1. Line 1
 2. Line 2
 3. Line 3

more text
TEXT;

		$expected = <<<HTML
<p>Some text here.</p>

<ol>
<li>Line 1</li>
<li>Line 2</li>
<li>Line 3</li>
</ol>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		$this->assertEqual($result, $expected);

		$text = <<<TEXT
Some text here.

 8. Line `with code`
 100. Line 2
 5. Line **bold**

more text
TEXT;

		$expected = <<<HTML
<p>Some text here.</p>

<ol>
<li>Line <code>with code</code></li>
<li>Line 2</li>
<li>Line <strong>bold</strong></li>
</ol>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		$this->assertEqual($result, $expected);
	}

/**
 * test nested one line lists
 *
 * @return void
 */
	function testNestedLists() {
		$text = <<<TEXT
Some text here.

 - Line 1
    - Indented 1
    - Indented 2
    - Indented 3
 - Line 2
 - Line 3

more text
TEXT;

		$expected = <<<HTML
<p>Some text here.</p>

<ul>
<li>Line 1
<ul>
<li>Indented 1</li>
<li>Indented 2</li>
<li>Indented 3</li>
</ul></li>
<li>Line 2</li>
<li>Line 3</li>
</ul>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		$this->assertEqual($result, $expected);

		$text = <<<TEXT
Some text here.

 - Line 1
    - Indented 1
    - Indented 2
        - Indented 3
 - Line 2
 - Line 3

more text
TEXT;

		$expected = <<<HTML
<p>Some text here.</p>

<ul>
<li>Line 1
<ul>
<li>Indented 1</li>
<li>Indented 2
<ul>
<li>Indented 3</li>
</ul></li>
</ul></li>
<li>Line 2</li>
<li>Line 3</li>
</ul>

<p>more text</p>
HTML;
		$result = $this->Parser->parse($text);
		var_dump($result);
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