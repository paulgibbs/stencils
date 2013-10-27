<?php
/**
 * Common functions
 *
 * Common functions are ones that are used by more than one component.
 *
 * @package Stencils
 * @subpackage CommonFunctions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Errors
 */

/**
 * Adds an error message to later be output in the theme
 *
 * @param string $code Unique code for the error message
 * @param string $message Translated error message
 * @param string $data Any additional data passed with the error message
 * @since Stencils (1.0)
 */
function dks_add_error( $code = '', $message = '', $data = '' ) {
	stencils()->errors->add( $code, $message, $data );
}

/**
 * Check if error messages exist in queue
 *
 * @since Stencils (1.0)
 */
function dks_has_errors() {
	$has_errors = stencils()->errors->get_error_codes() ? true : false; 

	return apply_filters( 'dks_has_errors', $has_errors, stencils()->errors );
}


/**
 * Versions
 */

/**
 * Output the Stencils version
 *
 * @since Stencils (1.0)
 */
function dks_version() {
	echo dks_get_version();
}
	/**
	 * Return the Stencils version
	 *
	 * @since Stencils (1.0)
	 * @return string The Stencils version
	 */
	function dks_get_version() {
		return stencils()->version;
	}

/**
 * Output the Stencils database version
 *
 * @uses dks_get_version() To get the Stencils DB version
 */
function dks_db_version() {
	echo dks_get_db_version();
}
	/**
	 * Return the Stencils database version
	 *
	 * @since Stencils (1.0)
	 * @return string The Stencils version
	 */
	function dks_get_db_version() {
		return stencils()->db_version;
	}

/**
 * Output the Stencils database version directly from the database
 *
 * @since Stencils (1.0)
 */
function dks_db_version_raw() {
	echo dks_get_db_version_raw();
}
	/**
	 * Return the Stencils database version directly from the database
	 *
	 * @return string The current Stencils version
	 * @since Stencils (1.0)
	 */
	function dks_get_db_version_raw() {
		return get_option( '_dks_db_version', '' );
	}

/**
 * Delete a site's rewrite rules so that they are automatically rebuilt on subsequent page load.
 *
 * @since Stencils (1.0)
 */
function dks_delete_rewrite_rules() {
	delete_option( 'rewrite_rules' );
}

/**
 * Merge user defined arguments into defaults array.
 *
 * This function is used throughout Stencils to allow for either a string or array
 * to be merged into another array. It is identical to dks_parse_args() except
 * it allows for arguments to be passively or aggressively filtered using the
 * optional $filter_key parameter.
 *
 * @param string|array $args Value to merge with $defaults
 * @param array $defaults Array that serves as the defaults.
 * @param string $filter_key String to key the filters from
 * @return array Merged user defined values with defaults.
 * @since Stencils (1.0)
 */
function dks_parse_args( $args, $defaults = array(), $filter_key = '' ) {
	// Setup a temporary array from $args
	if ( is_object( $args ) )
		$r = get_object_vars( $args );
	elseif ( is_array( $args ) )
		$r =& $args;
	else
		wp_parse_str( $args, $r );

	// Passively filter the args before the parse
	if ( ! empty( $filter_key ) )
		$r = apply_filters( 'dks_before_' . $filter_key . '_parse_args', $r );

	// Parse
	if ( is_array( $defaults ) && ! empty( $defaults ) )
		$r = array_merge( $defaults, $r );

	// Aggressively filter the args after the parse
	if ( ! empty( $filter_key ) )
		$r = apply_filters( 'dks_after_' . $filter_key . '_parse_args', $r );

	return $r;
}
