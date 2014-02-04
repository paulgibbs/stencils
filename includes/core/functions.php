<?php
/**
 * Core functions
 *
 * @package Stencils
 * @subpackage CoreFunctions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * If the current post is Stencils-powered, then load the full-width template for this theme.
 *
 * @param string $template_path Absolute path of the template to load.
 * @since Stencils (1.0)
 * @return string Absolute path of the template to load.
 */
function dks_maybe_load_stencils_template( $template_path ) {

	if ( ! is_singular() || ! dks_is_stencils_post() )
		return $template_path;

	// What this will eventually do is load the full-width template from the theme once that option is implemented.
	return apply_filters( 'dks_maybe_load_stencils_template', $template_path );
}


/**
 * "is" functions. Use these to help you make life-changing decisions.
 */

/**
 * Is the current post powered by Stencils?
 *
 * @param int $post_id Optional, defaults to {@link get_the_ID()}.
 * @since Stencils (1.0)
 * @return bool
 */
function dks_is_stencils_post( $post_id = 0 ) {

	if ( ! $post_id && is_singular() )
		$post_id = get_the_ID();

	if ( ! $post_id )
		return false;

	$retval = (bool) get_post_meta( $post_id, 'has_stencils', true );
	return (bool) apply_filters( 'dks_is_stencils_post', $retval, $post_id );
}