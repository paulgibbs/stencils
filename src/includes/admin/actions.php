<?php

/**
 * Stencils admin actions
 *
 * This file contains the actions that are used throughout Stencils admin. They
 * are consolidated here to make searching for them easier, and to help developers
 * understand at a glance the order in which things occur.
 *
 * @package Stencils
 * @subpackage AdminActions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Attach Stencils to WordPress
 *
 * Stencils uses its own internal actions to help aid in third-party plugin
 * development, and to limit the amount of potential future code changes when
 * updates to WordPress core occur.
 *
 * These actions exist to create the concept of 'plugin dependencies'. They
 * provide a safe way for plugins to execute code *only* when Stencils is
 * installed and activated, without needing to do complicated guesswork.
 */
add_action( 'admin_init', 'dks_admin_init' );
add_action( 'admin_menu', 'dks_admin_menu' );
add_action( 'admin_head', 'dks_admin_head' );

// Hook on to admin_init
add_action( 'dks_admin_init', 'dks_setup_updater',          999 );
add_action( 'dks_admin_init', 'dks_do_activation_redirect', 1   );

// Initialise the admin area
add_action( 'dks_init', 'dks_admin_setup' );

// Activation
add_action( 'dks_activation', 'dks_add_caps',             2 );
add_action( 'dks_activation', 'dks_delete_rewrite_rules', 4 );

// Deactivation
add_action( 'dks_deactivation', 'dks_remove_caps',          2 );
add_action( 'dks_deactivation', 'dks_delete_rewrite_rules', 4 );


// Sub-Actions

/**
 * Piggy-back admin_init action
 *
 * @since Stencils (1.0)
 */
function dks_admin_init() {
	do_action( 'dks_admin_init' );
}

/**
 * Piggy-back admin_menu action
 *
 * @since Stencils (1.0)
 */
function dks_admin_menu() {
	do_action( 'dks_admin_menu' );
}

/**
 * Piggy-back admin_head action
 *
 * @since Stencils (1.0)
 */
function dks_admin_head() {
	do_action( 'dks_admin_head' );
}