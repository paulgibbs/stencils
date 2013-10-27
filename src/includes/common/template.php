<?php
/**
 * Common template tags
 *
 * @package Stencils
 * @subpackage CommonTemplate
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add-on actions
 */

/**
 * Add our custom head action to wp_head
 *
 * @since Stencils (1.0)
 */
function dks_head() {
	do_action( 'dks_head' );
}

/**
 * Add our custom head action to wp_head
 *
 * @since Stencils (1.0)
 */
function dks_footer() {
	do_action( 'dks_footer' );
}

/**
 * Use the above is_() functions to output a body class for each possible scenario
 *
 * @param array $wp_classes
 * @param array $custom_classes Optional
 * @return array Body Classes
 * @since Stencils (1.0)
 */
function dks_body_class( $wp_classes, $custom_classes = array() ) {
	return apply_filters( 'dks_body_class', $wp_classes, $custom_classes );
}
