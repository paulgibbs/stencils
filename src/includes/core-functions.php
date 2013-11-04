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
 * Load the translation file for current language. Checks the default WordPress languages folder.
 *
 * @since Stencils (1.0)
 */
function dks_load_textdomain() {

	// Try to load via load_plugin_textdomain() first, for future wordpress.org translation downloads
	if ( load_plugin_textdomain( 'stencils', false, 'stencils' ) )
		return;

	$locale = apply_filters( 'plugin_locale', get_locale(), 'stencils');
	$mofile = sprintf( WP_LANG_DIR + '/plugins/stencils-%2$s.mo', $locale );

	load_textdomain( 'stencils', $mofile );
}

/**
 * Add custom image sizes for image cropping
 *
 * @since Stencils (1.0)
 */
function dks_add_image_sizes() {}

/**
 * Change the <body> element's CSS class
 *
 * @param array $wp_classes
 * @param array $custom_classes Optional
 * @return array
 * @since Stencils (1.0)
 */
function dks_body_class( $wp_classes, $custom_classes = array() ) {
	return apply_filters( 'dks_body_class', $wp_classes, $custom_classes );
}
