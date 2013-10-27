<?php
/**
 * Stencils for WordPress
 *
 * @author Paul Gibbs <paul@byotos.com>
 * @package Stencils
 * @subpackage Loader
 */

/*
Plugin Name: Stencils
Plugin URI: http://StencilsTodo.com/
Description: StencilsTodo
Version: 1.0
Requires at least: 3.7
Tested up to: 3.8.20
License: GPLv3
Author: Paul Gibbs
Author URI: http://byotos.com/
Text Domain: stencils
Network: false

"Stencils"
Copyright (C) 2013 Paul Gibbs

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License version 3 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/.
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DKS_Stencils_Loader' ) ) :
/**
 * Main Stencils class
 *
 * @since Stencils (1.0)
 */
final class DKS_Stencils_Loader {
	/**
	 * Stencils uses many variables, several of which can be filtered to
	 * customise the way it operates. Most of these variables are stored in a
	 * private array that gets updated with the help of PHP magic methods.
	 *
	 * This is a precautionary measure to avoid potential errors produced by
	 * unanticipated direct manipulation of Stencils' run-time data.
	 *
	 * @see Stencils::setup_globals()
	 * @var array
	 */
	private $data;

	/**
	 * @var array Overloads get_option()
	 */
	public $options = array();


	/**
	 * Main Stencils instance
	 *
	 * Insures that only one instance of Stencils exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @return DKS_Stencils_Loader The one true Stencils
	 * @see stencils()
	 * @since Stencils (1.0)
	 */
	public static function instance() {
		static $instance = null;

		if ( null === $instance ) {
			$instance = new DKS_Stencils_Loader;
			$instance->setup_globals();
			$instance->includes();
			$instance->setup_actions(); 
		}

		return $instance;
	}


	// Magic Methods

	/**
	 * A dummy constructor to prevent Stencils from being loaded more than once.
	 *
	 * @since Stencils (1.0)
	 */
	private function __construct() {}

	/**
	 * A dummy magic method to prevent Stencils from being cloned
	 *
	 * @since Stencils (1.0)
	 */
	public function __clone() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'stencils' ), '1.0' ); }

	/**
	 * A dummy magic method to prevent Stencils from being unserialised
	 *
	 * @since Stencils (1.0)
	 */
	public function __wakeup() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'stencils' ), '1.0' ); }

	/**
	 * Magic method for checking the existence of a certain custom field
	 *
	 * @param string $key
	 * @since Stencils (1.0)
	 */
	public function __isset( $key ) { return isset( $this->data[$key] ); }

	/**
	 * Magic method for getting Stencils variables
	 *
	 * @param string $key
	 * @since Stencils (1.0)
	 */
	public function __get( $key ) { return isset( $this->data[$key] ) ? $this->data[$key] : null; }

	/**
	 * Magic method for setting Stencils variables
	 *
	 * @param string $key
	 * @param mixed $value
	 * @since Stencils (1.0)
	 */
	public function __set( $key, $value ) { $this->data[$key] = $value; }

	/**
	 * Magic method for unsetting Stencils variables
	 *
	 * @param string $key
	 * @since Stencils (1.0)
	 */
	public function __unset( $key ) { if ( isset( $this->data[$key] ) ) unset( $this->data[$key] ); }


	// Private methods

	/**
	 * Set up global variables
	 *
	 * @since Stencils (1.0)
	 */
	private function setup_globals() {
		// Versions
		$this->version    = 1.0;
		$this->db_version = 100;

		// Paths
		$this->file       = __FILE__;
		$this->basename   = apply_filters( 'dks_basenname',       plugin_basename( $this->file ) );
		$this->plugin_dir = apply_filters( 'dks_plugin_dir_path', plugin_dir_path( $this->file ) );
		$this->plugin_url = apply_filters( 'dks_plugin_dir_url',  plugin_dir_url ( $this->file ) );

		// Includes
		$this->includes_dir = apply_filters( 'dks_includes_dir', trailingslashit( $this->plugin_dir . 'includes' ) );
		$this->includes_url = apply_filters( 'dks_includes_url', trailingslashit( $this->plugin_url . 'includes' ) );

		// Other stuff
		$this->domain = 'stencils';      // Unique identifier for retrieving translated strings
		$this->errors = new WP_Error();  // Errors

		/**
		 * If multisite and running network-wide, grab the options from the site options
		 * table and store in stencils()->options. dks_setup_option_filters() sets
		 * up a pre_option filter which loads from stencils()->options if an option
		 * has been set there. This saves a lot of conditionals throughout the plugin.
		 */
		if ( is_multisite() && dks_is_running_networkwide() ) {
			$options = dks_get_default_options();
			foreach ( $options as $option_name => $option_value )
				stencils()->options[$option_name] = get_site_option( $option_name );
		}
	}

	/**
	 * Include required files
	 *
	 * @since Stencils (1.0)
	 */
	private function includes() {
		/**
		 * Core
		 */
		require( $this->includes_dir . 'core/dependency.php' );
		require( $this->includes_dir . 'core/functions.php'  );
		require( $this->includes_dir . 'core/options.php'    );
		require( $this->includes_dir . 'core/caps.php'       );
		require( $this->includes_dir . 'core/update.php'     );


		/**
		 * Components
		 */
		require( $this->includes_dir . 'common/functions.php'  );
		require( $this->includes_dir . 'common/template.php'   );


		/**
		 * Hooks
		 */
		require( $this->includes_dir . 'core/actions.php' );
		require( $this->includes_dir . 'core/filters.php' );


		/**
		 * Admin
		 */
		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			require( $this->includes_dir . 'admin/admin.php'   );
			require( $this->includes_dir . 'admin/actions.php' );
		}
	}

	/**
	 * Set up the default hooks and actions
	 *
	 * @since Stencils (1.0)
	 */
	private function setup_actions() {
		// Plugin activation and deactivation hooks
		add_action( 'activate_'   . $this->basename, 'dks_activation'   );
		add_action( 'deactivate_' . $this->basename, 'dks_deactivation' );

		// If Stencils is being deactivated, don't add any more actions
		if ( dks_is_deactivation( $this->basename ) )
			return;

		// Add the core actions
		$actions = array(
			'load_textdomain',       // Load textdomain
			'register_image_sizes',  // Add custom image sizes
		);

		foreach( $actions as $class_action )
			add_action( 'dks_' . $class_action, array( $this, $class_action ), 5 );

		// All Stencils actions are setup (includes core/actions.php)
		do_action_ref_array( 'dks_after_setup_actions', array( &$this ) );
	}

	/**
	 * Load the translation file for current language. Checks the default WordPress languages folder.
	 *
	 * @since Stencils (1.0)
	 */
	public function load_textdomain() {

		// Try to load via load_plugin_textdomain() first, for future wordpress.org translation downloads
		if ( load_plugin_textdomain( $this->domain, false, 'stencils' ) )
			return;

		$locale = apply_filters( 'plugin_locale', get_locale(), $this->domain );
		$mofile = sprintf( '/plugins/%1$s-%2$s.mo', $this->domain, $locale );

		$mofile_global = WP_LANG_DIR . $mofile;
		load_textdomain( $this->domain, $mofile_global );
	}

	/**
	 * Add custom image sizes for image cropping
	 *
	 * @since Stencils (1.0)
	 */
	public function register_image_sizes() {
	}
}

/**
 * Checks if the plugin across entire network, rather than on a specific site (for multisite).
 *
 * Needs to be in scope for DKS_Stencils_Loader::setup_globals(), so it's not in core/options.php
 *
 * @return bool
 * @since Stencils (1.0)
 * @todo Review if is_plugin_active_for_network() not being available on Network Activation is a WP core bug.
 */
function dks_is_running_networkwide() {
	$retval = false;

	if ( is_multisite() ) {
		$plugins = get_site_option( 'active_sitewide_plugins' );
		if ( isset( $plugins[stencils()->basename] ) )
			$retval = true;
	}

	return (bool) apply_filters( 'dks_is_running_networkwide', $retval );
}

/**
 * Get the default site options and their values
 *
 * Needs to be in scope for DKS_Stencils_Loader::setup_globals(), so it's not in core/options.php
 *
 * @return array Option names and values
 * @since Stencils (1.0)
 */
function dks_get_default_options() {
	$options = array(
		'_dks_db_version' => stencils()->db_version,  // Initial DB version
	);

	return apply_filters( 'dks_get_default_options', $options );
}

/**
 * The main function responsible for returning the one true Stencils instance.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @return DKS_Stencils_Loader The one true Stencils instance
 * @since Stencils (1.0)
 */
function stencils() {
	return DKS_Stencils_Loader::instance();
}

/**
 * Hook Stencils early onto the 'plugins_loaded' action.
 *
 * This gives all other plugins the chance to load before Stencils to get their
 * actions, filters, and overrides setup without Stencils being in the way.
 */
if ( defined( 'DKS_LATE_LOAD' ) ) {
	add_action( 'plugins_loaded', 'stencils', (int) DKS_LATE_LOAD );

// There's that word again, "heavy." Why are things so heavy in the future? Is there a problem with the Earth's gravitational pull?
} else {
	stencils();
}

endif; // class_exists check