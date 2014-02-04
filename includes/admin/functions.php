<?php
/**
 * Admin functions
 *
 * @package Stencils
 * @subpackage AdminFunctions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * When a post is saved, maybe generate a stencil template.
 *
 * @param int $post_i
 */
function dks_maybe_generate_stencil( $post_id ) {

	// Bail if doing an autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	// Bail if not a post request
	if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
		return $post_id;

	// Bail if not saving a Stencils-supported post type
	if ( ! in_array( get_post_type( $post_id ), dks_get_stencils_post_types() ) )
		return $post_id;

	// Bail if current user cannot edit this post
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return $post_id;

	// Bail if the user doesn't want this to be a stencils post
	// DJPAULTODO: this assume post meta is set *before* we get here. We might need to revisit this assumption ;)
	if ( ! dks_is_stencils_post( $post_id ) )
		return;

	dks_generate_stencil( $post_id );
}

function dks_generate_stencil( $post_id ) {
	// can't touch this
}