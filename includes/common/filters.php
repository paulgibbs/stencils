<?php
/**
 * Common filters
 *
 * This file contains the filters that are used throughout Stencils. They are consolidated here to make searching for them easier, and to help developers understand at a glance the order in which things occur.
 *
 * @package Stencils
 * @subpackage CommonFilters
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Attach Stencils to WordPress
 */
add_filter( 'body_class',       'dks_body_class', 10, 2 );
add_filter( 'template_include', 'dks_maybe_load_stencils_template' );
