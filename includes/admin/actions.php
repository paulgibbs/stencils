<?php
/**
 * Stencils admin actions
 *
 * This file contains the actions that are used throughout Stencils. They are consolidated here to make searching for them easier, and to help developers understand at a glance the order in which things occur.
 *
 * @package Stencils
 * @subpackage AdminActions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Attach Stencils to WordPress
 *
 * Stencils uses its own internal actions to help aid in additional plugin development, and to limit the amount of potential future code changes when updates to WordPress occur.
 */
add_action( 'admin_init', 'dks_admin_init' );

// When WordPress updates a post, update its stencil.
add_action( 'save_post', 'dks_maybe_generate_stencil' );

/**
 * Piggy back admin_init action
 *
 * @since Stencils (1.0)
 */
function dks_admin_init() {
	do_action( 'dks_admin_init' );
}