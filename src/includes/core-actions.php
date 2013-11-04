<?php
/**
 * Core actions
 *
 * This file contains the actions that are used throughout Stencils. They are consolidated here to make searching for them easier, and to help developers understand at a glance the order in which things occur.
 * 
 * @package Stencils
 * @subpackage CoreActions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Attach Stencils to WordPress
 *
 * Stencils uses its own internal actions to help aid in additional plugin
 * development, and to limit the amount of potential future code changes when
 * updates to WordPress occur.
 */
add_action( 'plugins_loaded',     'dks_loaded',           10 );
add_action( 'init',               'dks_init',             0  ); // Early for dks_register 
add_action( 'wp_enqueue_scripts', 'dks_enqueue_scripts',  10 );
add_action( 'wp_head',            'dks_head',             10 );
add_action( 'wp_footer',          'dks_footer',           10 );

/**
 * dks_loaded - Attached to 'plugins_loaded' above
 *
 * Attach various loader actions to the dks_loaded action.
 */
add_action( 'dks_loaded', 'dks_internationalisation', 2 );

/**
 * dks_init - Attached to 'init' above
 *
 * Attach various initialisation actions to the init action.
 */
add_action( 'dks_init', 'dks_register', 0   );
add_action( 'dks_init', 'dks_ready',    999 );

/**
 * dks_register - Attached to 'init' above on 0 priority
 *
 * Attach various initilisation actions early to the init action.
 * The load order helps to execute code at the correct time.
 */
add_action( 'dks_register', 'dks_add_image_sizes', 2 );


/**
 * Actions past this point all hook actual functions, not psuedo-wrapper functions.
 */

// Internationalisation
add_action( 'dks_internationalisation', 'dks_load_textdomain' );
