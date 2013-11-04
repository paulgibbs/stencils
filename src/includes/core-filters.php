<?php
/**
 * Core filters
 *
 * This file contains the filters that are used throughout Stencils. They are consolidated here to make searching for them easier, and to help developers understand at a glance the order in which things occur.
 *
 * @package Stencils
 * @subpackage CoreFilters
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Attach Stencils to WordPress
 *
 * Stencils uses its own internal actions to help aid in additional plugin development, and to limit the amount of potential future code changes when updates to WordPress occur.
 */
add_filter( 'body_class', 'dks_body_class', 10, 2 );
