<?php
/**
 * Core filters
 *
 * This file contains the filters that are used throughout Stencils. They are
 * consolidated here to make searching for them easier, and to help developers
 * understand at a glance the order in which things occur.
 *
 * @package Stencils
 * @subpackage CoreFilters
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
add_filter( 'body_class',    'dks_body_class',    12, 2 );
add_filter( 'map_meta_cap',  'dks_map_meta_caps', 10, 4 );
add_filter( 'plugin_locale', 'dks_plugin_locale', 10, 2 );
