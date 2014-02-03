<?php
/**
 * Plugin dependency
 *
 * The purpose of the following actions is to mimic the behaviour of something called 'plugin dependency' which enables a plugin to have plugins of their own in a safe and reliable way.
 * This is also done in Achievements, BuddyPress, and bbPress. We do this by mirroring existing WordPress actions in many places allowing dependant plugins to hook into the Stencils-specific ones, thus guaranteeing proper code execution.
 *
 * @package Stencils
 * @subpackage CoreDependencies
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Main action responsible for constants, globals, and includes
 *
 * @since Stencils (1.0)
 */
function dks_loaded() {
	do_action( 'dks_loaded' );
}

/**
 * Initialise any code after everything has been loaded
 *
 * @since Stencils (2.0)
 */
function dks_init() {
	do_action( 'dks_init' );
}

/** 
 * Register any objects before anything is initialised.
 * 
 * @since Stencils (1.0)
 */ 
function dks_register() { 
	do_action( 'dks_register' );
}

/**
 * Everything's loaded and ready to go!
 *
 * @since Stencils (1.0)
 */
function dks_ready() {
	do_action( 'dks_ready' );
}


/**
 * Supplemental actions
 */

/**
 * Enqueue CSS and JS
 *
 * @since Stencils (1.0)
 */
function dks_enqueue_scripts() {
	do_action( 'dks_enqueue_scripts' );
}

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
