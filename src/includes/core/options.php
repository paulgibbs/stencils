<?php
/**
* Stencils options
*
* @package Stencils
* @subpackage CoreOptions
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add default options to DB
 *
 * This is only called when the plugin is activated and is non-destructive,
 * so existing settings will not be overridden.
 *
 * @since Stencils (1.0)
 */
function dks_add_options() {
	$options = dks_get_default_options();

	// Add default options
	foreach ( $options as $key => $value )
		add_option( $key, $value );

	// Let other plugins add any extra options
	do_action( 'dks_add_options' );
}

/**
 * Delete default options
 *
 * Hooked to dks_uninstall, it is only called when the plugin is uninstalled.
 * This is destructive, so existing settings will be destroyed.
 *
 * @since Stencils (1.0)
 */
function dks_delete_options() {
	// Delete default options
	foreach ( array_keys( dks_get_default_options() ) as $key )
		delete_option( $key );

	// Let other plugins delete any extra options which they've added
	do_action( 'dks_delete_options' );
}

/**
 * Add filters to each Stencils option and allow them to be overloaded
 * from inside the stencils()->options array.
 * 
 * @since Stencils (1.0)
 */
function dks_setup_option_filters() {
	// Add filters to each option
	foreach ( array_keys( dks_get_default_options() ) as $key )
		add_filter( 'pre_option_' . $key, 'dks_pre_get_option' );

	// Let other plugins add their own option filters
	do_action( 'dks_setup_option_filters' );
}

/**
 * Filter default options and allow them to be overloaded from inside the
 * stencils()->options array.
 *
 * @param string $value
 * @return mixed
 * @since Stencils (1.0)
 */
function dks_pre_get_option( $value = '' ) {
	// Get the name of the current filter so we can manipulate it, and remove the filter prefix
	$option = str_replace( 'pre_option_', '', current_filter() );

	// Check the options global for preset value
	if ( isset( stencils()->options[$option] ) )
		$value = stencils()->options[$option];

	return $value;
}
