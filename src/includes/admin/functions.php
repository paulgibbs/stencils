<?php
/**
 * Stencils admin functions
 *
 * @package Stencils
 * @subpackage AdminFunctions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Redirect user to Stencils' welcome screen on activation
 *
 * @since Stencils (1.0)
 */
function dks_do_activation_redirect() {

	// Bail if no activation redirect
	if ( ! get_transient( '_dks_activation_redirect' ) )
		return;

	delete_transient( '_dks_activation_redirect' );

	// Bail if activating from network, or bulk.
	if ( isset( $_GET['activate-multi'] ) )
		return;

	$query_args = array( 'page' => 'stencils-about' );

	if ( get_transient( '_dks_is_new_install' ) ) {
		$query_args['is_new_install'] = '1';
		delete_transient( '_dks_is_new_install' );
	}

	wp_safe_redirect( add_query_arg( $query_args, admin_url( 'index.php' ) ) );
}
