<?php
/**
 * Plugin Dependency
 *
 * The purpose of the following actions is to mimic the behaviour of something
 * called 'plugin dependency' which enables a plugin to have plugins of their
 * own in a safe and reliable way.
 *
 * This is done in BuddyPress and bbPress. We do this by mirroring existing
 * WordPress actions in many places allowing dependant plugins to hook into
 * the Stencils specific ones, thus guaranteeing proper code execution.
 *
 * @package Stencils
 * @subpackage CoreDependency
 */

/**
 * Activation actions
 */

/**
 * Runs on plugin activation
 *
 * @since Stencils (1.0)
 */
function dks_activation() {
	do_action( 'dks_activation' );
}

/**
 * Runs on plugin deactivation
 *
 * @since Stencils (1.0)
 */
function dks_deactivation() {
	do_action( 'dks_deactivation' );
}

/**
 * Runs when uninstalling the plugin
 *
 * @since Stencils (1.0)
 */
function dks_uninstall() {
	do_action( 'dks_uninstall' );
}


/**
 * Main actions
 */

/**
 * Main action responsible for constants, globals, and includes
 *
 * @since Stencils (1.0)
 */
function dks_loaded() {
	do_action( 'dks_loaded' );
}

/**
 * Set up globals AFTER includes
 *
 * @since Stencils (1.0)
 */
function dks_setup_globals() {
	do_action( 'dks_setup_globals' );
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
 * Supplemental actions
 */

/**
 * Load translations for current language
 *
 * @since Stencils (1.0)
 */
function dks_load_textdomain() {
	do_action( 'dks_load_textdomain' );
}

/**
 * Enqueue CSS and JS
 *
 * @since Stencils (1.0)
 */
function dks_enqueue_scripts() {
	do_action( 'dks_enqueue_scripts' );
}

/**
 * Add custom image sizes for cropping
 *
 * @since Stencils (1.0)
 */
function dks_register_image_sizes() {
	do_action( 'dks_register_image_sizes' );
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
 * Misc helpers
 */

/**
 * Filter the plugin locale and domain.
 *
 * @param string $locale Optional
 * @param string $domain Optionl
 * @since Stencils (1.0)
 */
function dks_plugin_locale( $locale = '', $domain = '' ) {

	// Only filter the dpa text domain
	if ( stencils()->domain !== $domain )
		return $locale;

	return apply_filters( 'dks_plugin_locale', $locale, $domain );
}
