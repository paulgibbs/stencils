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
Plugin URI: http://stencilsplugin.com/
Description: StencilsTodo
Version: 1.0
Requires at least: 3.8.1
Tested up to: 3.8.20
License: GPLv3
Author: Paul Gibbs
Author URI: http://byotos.com/
Text Domain: stencils
Network: false

"Stencils"
Copyright (C) 2013-14 Paul Gibbs

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
	 * Stencils uses many variables, several of which can be filtered to customise the way it operates. Most of these variables are stored in a private array that gets updated with the help of PHP magic methods.
	 *
	 * This is a precautionary measure to avoid potential errors produced by unanticipated direct manipulation of Stencils' run-time data.
	 *
	 * @see Stencils::setup_globals()
	 * @var array
	 */
	private $data = array();

	/**
	 * Get the main Stencils instance
	 *
	 * Insures that only one instance of Stencils exists in memory at any one time.
	 * Also prevents needing to define globals all over the place.
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
		}

		return $instance;
	}

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
		$this->version    = '3.8.1';
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
		$this->domain = 'stencils';  // Unique identifier for retrieving translated strings
	}

	/**
	 * Include required files
	 *
	 * @since Stencils (1.0)
	 */
	private function includes() {
		require( $this->includes_dir . 'common/dependencies.php' );  // load first
		require( $this->includes_dir . 'common/functions.php'    );
		require( $this->includes_dir . 'common/actions.php'      );
		require( $this->includes_dir . 'common/filters.php'      );
		require( $this->includes_dir . 'core/functions.php'      );

		/**
		 * Admin
		 */
		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {}

		/**
		 * WP-CLI
		 */
		if ( defined( 'WP_CLI' ) && WP_CLI ) {}
	}
}

/**
 * The main function responsible for returning the one true Stencils instance.
 *
 * Use this function like you would a global variable, except without needing to declare the global.
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
 * This gives all other plugins the chance to load before Stencils to get their actions, filters, and overrides setup without Stencils being in the way.
 */
if ( defined( 'DKS_LATE_LOAD' ) ) {
	add_action( 'plugins_loaded', 'stencils', (int) DKS_LATE_LOAD );

// There's that word again, "heavy." Why are things so heavy in the future? Is there a problem with the Earth's gravitational pull?
} else {
	stencils();
}

endif; // class_exists check