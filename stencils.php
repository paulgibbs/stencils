<?php
/**
 * Plugin name: Stencils
 */

$input = <<<EOF
<div class="entry-content">
<p>This is an example page. It’s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>
<blockquote><p>Hi there! I’m a bike messenger by day, aspiring actor by night, and this is my blog. I live in Los Angeles, have a great dog named Jack, and I like piña coladas. (And gettin’ caught in the rain.)</p></blockquote>
<p>…or something like this:</p>
<blockquote><p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickies to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p></blockquote>
<p>As a new WordPress user, you should go to <a href="http://www.nsccenter.com/wordpress/wp-admin/">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>
</div>
EOF;

//http://stackoverflow.com/questions/3820666/grabbing-the-href-attribute-of-an-a-element/3820783#3820783

$dom = new DOMDocument;
$dom->loadHTML( $input );
$xpath = new DOMXPath( $dom );

echo '<style>
#demo blockquote {
	background-color: blue;
}

.entry-content > p {
	color: red;
}

#demo a {
	background-color: yellow;
}
</style>';

echo '<h1>DOMDocument demo</h1>';
echo "<p><blockquote id='demo' style='outline: 1px solid black;'>{$input}</blockquote></p>";

echo '<p>Number of paragraphs (red) (should be 3): ' . $xpath->query( "descendant-or-self::*[contains(concat(' ', normalize-space(@class), ' '), ' entry-content ')]/p" )->length . '</p>';
echo '<p>Number of blockquotes (blue): ' . $dom->getElementsByTagName( 'blockquote' )->length . '</p>';
echo '<p>Number of links (yellow): ' . $dom->getElementsByTagName( 'a' )->length . '</p>';