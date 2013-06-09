<?php
/**
 * Plugin name: Stencils
 */

function stencils_hack_the_content( $the_content ) {
	preg_match_all( '|(?<!<br />)\s*\n|', $the_content, $matches );
	$matches = $matches[0];

	// Start to figure out ways of getting information we need - paragraphs, blockquotes, images, galleries.
	$number_of_paragraphs = count( $matches );

	return $the_content;
}
add_filter( 'the_content', 'stencils_hack_the_content', -100 );

function stencils_test_the_content( $the_content ) {
}
//add_filter( 'the_content', 'stencils_test_the_content' );