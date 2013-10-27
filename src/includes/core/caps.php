<?php
/**
 * Stencils Capabilities
 *
 * @package Stencils
 * @subpackage CoreCapabilities
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Adds capabilities to WordPress user roles.
 *
 * This is called on plugin activation.
 *
 * @since Stencils (1.0)
 */
function dks_add_caps() {
	global $wp_roles;

	// Load roles if not set
	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();

	// Loop through available roles
	foreach( $wp_roles->roles as $role => $details ) {

		// Load this role
		$this_role = get_role( $role );

		// Loop through available caps for this role and add them
		foreach ( dks_get_caps_for_role( $role ) as $cap ) {
			$this_role->add_cap( $cap );
		}
	}

	do_action( 'dks_add_caps' );
}

/**
 * Removes capabilities from WordPress user roles.
 *
 * This is called on plugin deactivation.
 *
 * @since Stencils (1.0)
 */
function dks_remove_caps() {
	global $wp_roles;

	// Load roles if not set
	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();

	// Loop through available roles
	foreach( $wp_roles->roles as $role => $details ) {

		// Load this role
		$this_role = get_role( $role );

		// Loop through caps for this role and remove them
		foreach ( dks_get_caps_for_role( $role ) as $cap ) {
			$this_role->remove_cap( $cap );
		}
	}

	do_action( 'dks_remove_caps' );
}

/**
 * Maps custom caps to built-in WordPress caps
 *
 * @param array $caps Capabilities for meta capability
 * @param string $cap Capability name
 * @param int $user_id User id
 * @param mixed $args Arguments
 * @return array Actual capabilities for meta capability
 * @since Stencils (1.0)
 */
function dks_map_meta_caps( $caps, $cap, $user_id, $args ) {
	return apply_filters( 'dks_map_meta_caps', $caps, $cap, $user_id, $args );
}

/**
 * Returns an array of capabilities based on the role that is being requested.
 *
 * @param string $role Optional. Defaults to The role to load caps for
 * @return array Capabilities for $role
 * @since Stencils (1.0)
 */
function dks_get_caps_for_role( $role = '' ) {
	return apply_filters( 'dks_get_caps_for_role', array(), $role );
}
