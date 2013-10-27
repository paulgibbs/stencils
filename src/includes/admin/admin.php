<?php
/**
 * Main Stencils Admin Class
 *
 * @package Stencils
 * @subpackage Admin
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DKS_Admin' ) ) :
/**
 * Sets up the Stencils admin area
 *
 * @since Stencils (1.0)
 */
class DKS_Admin {
	// Paths

	/**
	 * @var string Path to the Stencils admin directory
	 */
	public $admin_dir = '';

	/**
	 * @var string URL to the Stencils admin directory
	 */
	public $admin_url = '';

	/**
	 * @var string URL to the Stencils admin css directory
	 */
	public $css_url = '';

	/**
	 * @var string URL to the Stencils admin image directory
	 */
	public $images_url = '';

	/**
	 * @var string URL to the Stencils admin javascript directory
	 */
	public $javascript_url = '';


	// Capability

	/**
	 * @var bool Minimum capability to access Settings
	 */
	public $minimum_capability = 'manage_options';


	/**
	 * The main Stencils admin loader
	 *
	 * @since Stencils (1.0)
	 */
	public function __construct() {
		$this->setup_globals();
		$this->includes();
		$this->setup_actions();
	}

	/**
	 * Set up the admin hooks, actions and filters
	 *
	 * @since Stencils (1.0)
	 */
	private function setup_actions() {

		// Bail to prevent interfering with the deactivation process 
		if ( dks_is_deactivation() )
			return;

		add_action( 'dks_admin_menu', array( $this, 'admin_menus' ) );

		do_action_ref_array( 'dks_admin_loaded', array( &$this ) );
	}

	/**
	 * Include required files
	 *
	 * @since Stencils (1.0)
	 */
	private function includes() {
		require( $this->admin_dir . 'functions.php' );
	}

	/**
	 * Set admin globals
	 *
	 * @since Stencils (1.0)
	 */
	private function setup_globals() {
		$this->admin_dir      = trailingslashit( stencils()->includes_dir . 'admin'  ); // Admin path
		$this->admin_url      = trailingslashit( stencils()->includes_url . 'admin'  ); // Admin URL
		$this->css_url        = trailingslashit( $this->admin_url         . 'css'    ); // Admin CSS URL
		$this->images_url     = trailingslashit( $this->admin_url         . 'images' ); // Admin images URL
		$this->javascript_url = trailingslashit( $this->admin_url         . 'js'     ); // Admin javascript URL
	}

	/**
	 * Add wp-admin menus
	 *
	 * @since Stencils (1.0)
	 */
	public function admin_menus() {

		// Welcome screen
		add_dashboard_page(
			__( 'Welcome to Stencils', 'stencils' ),
			__( 'Welcome to Stencils', 'stencils' ),
			$this->minimum_capability,
			'stencils-about',
			array( $this, 'about_screen' )
		);
		remove_submenu_page( 'index.php', 'stencils-about' );
	}

	/**
	 * Output the about screen
	 *
	 * @since Stencils (1.0)
	 */
	public function about_screen() {
		$is_new_install = ! empty( $_GET['is_new_install'] );
	?>

		<style type="text/css">
		.about-text {
			margin-right: 0;
		}
		</style>

		<div class="wrap about-wrap">
			<h1><?php _e( 'Welcome to Stencils', 'stencils' ); ?></h1>

			<div class="about-text">
				<?php _e( 'Imagine a totally rad welcome screen here.', 'stencils' ); ?>
			</div>
		</div>

		<?php
	}
}
endif; // class_exists check

/**
 * Set up Stencils' Admin
 *
 * @since Stencils (1.0)
 */
function dks_admin_setup() {
	stencils()->admin = new DKS_Admin();
}