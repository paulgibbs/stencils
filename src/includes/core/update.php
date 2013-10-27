<?php
/**
 * Stencils Updater
 *
 * @package Stencils
 * @subpackage CoreUpdate
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * If there is no raw DB version, this is the first installation
 *
 * @return bool True if update, False if not
 * @since Stencils (1.0)
 */
function dks_is_install() {
	return ! dks_get_db_version_raw();
}

/**
 * Compare the Stencils version to the DB version to determine if updating
 *
 * @return bool True if update, False if not
 * @since Stencils (1.0)
 */
function dks_is_update() {
	return (bool) ( (int) dks_get_db_version_raw() < (int) dks_get_db_version() );
}

/**
 * Determine if Stencils is being activated
 *
 * @param string $basename Optional
 * @return bool True if activating Stencils, false if not
 * @since Stencils (1.0)
 */
function dks_is_activation( $basename = '' ) {
	global $pagenow;

	// Bail if not in admin/plugins
	if ( ! is_admin() || 'plugins.php' !== $pagenow )
		return false;

	$action = false;

	if ( ! empty( $_REQUEST['action'] ) && '-1' !== $_REQUEST['action'] )
		$action = $_REQUEST['action'];
	elseif ( ! empty( $_REQUEST['action2'] ) && '-1' !== $_REQUEST['action2'] )
		$action = $_REQUEST['action2'];

	// Bail if not activating
	if ( empty( $action ) || ! in_array( $action, array( 'activate', 'activate-selected' ) ) )
		return false;

	// The plugin(s) being activated
	if ( $action === 'activate' )
		$plugins = isset( $_GET['plugin'] ) ? array( $_GET['plugin'] ) : array();
	else
		$plugins = isset( $_POST['checked'] ) ? (array) $_POST['checked'] : array();

	// Set basename if empty
	if ( empty( $basename ) && ! empty( stencils()->basename ) )
		$basename = stencils()->basename;

	// Bail if no basename
	if ( empty( $basename ) )
		return false;

	// Is Stencils being activated?
	return in_array( $basename, $plugins );
}

/**
 * Determine if Stencils is being deactivated
 *
 * @param string $basename Optional
 * @return bool True if deactivating Stencils, false if not
 * @since Stencils (1.0)
 */
function dks_is_deactivation( $basename = '' ) {
	global $pagenow;

	// Bail if not in admin/plugins
	if ( ! is_admin() || 'plugins.php' !== $pagenow )
		return false;

	$action = false;

	if ( ! empty( $_REQUEST['action'] ) && '-1' !== $_REQUEST['action'] )
		$action = $_REQUEST['action'];
	elseif ( ! empty( $_REQUEST['action2'] ) && '-1' !== $_REQUEST['action2'] )
		$action = $_REQUEST['action2'];

	// Bail if not deactivating
	if ( empty( $action ) || ! in_array( $action, array( 'deactivate', 'deactivate-selected' ) ) )
		return false;

	// The plugin(s) being deactivated
	if ( $action === 'deactivate' )
		$plugins = isset( $_GET['plugin'] ) ? array( $_GET['plugin'] ) : array();
	else
		$plugins = isset( $_POST['checked'] ) ? (array) $_POST['checked'] : array();

	// Set basename if empty
	if ( empty( $basename ) && ! empty( stencils()->basename ) )
		$basename = stencils()->basename;

	// Bail if no basename
	if ( empty( $basename ) )
		return false;

	// Is Stencils being deactivated?
	return in_array( $basename, $plugins );
}

/**
 * Update Stencils to the latest version
 *
 * @since Stencils (1.0)
 */
function dks_version_bump() {
	$db_version = dks_get_db_version();
	update_option( '_dks_db_version', $db_version );
}

/**
 * Set up Stencils' updater
 *
 * @since Stencils (1.0)
 */
function dks_setup_updater() {
	// Bail if no update needed
	if ( ! dks_is_update() )
		return;

	// Call the automated updater
	dks_version_updater();
}

/**
 * Stencils' version updater looks at what the current database version is and
 * runs whatever other code is needed.
 *
 * This is most-often used when the data schema changes, but should also be used
 * to correct issues with Stencils meta-data silently on software update.
 *
 * @since Stencils (1.0)
 */
function dks_version_updater() {
	// Get the raw database version
	$raw_db_version = (int) dks_get_db_version_raw();

	// Chill; there's nothing to do for now!

	// Bump the version
	dks_version_bump();

	// Delete rewrite rules to force a flush
	dks_delete_rewrite_rules();
}

/**
 * Redirect user to Stencils' "What's New" page on activation
 *
 * @since Stencils (1.0)
 */
function dks_add_activation_redirect() {

	// Bail if activating from network, or bulk.
	if ( isset( $_GET['activate-multi'] ) )
		return;

	// Record that this is a new installation, so we show the right welcome message
	if ( dks_is_install() )
		set_transient( '_dks_is_new_install', true, 30 );

	// Add the transient to redirect
	set_transient( '_dks_activation_redirect', true, 30 );
}
