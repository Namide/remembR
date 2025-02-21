<?php
/**
 * Plugin Name:       RemembR
 * Plugin URI:        https://github.com/Namide/remembR
 * Description:       Short question to test your knowledge
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Namide
 * License:           GPL-3.0 license 
 * License URI:       https://github.com/wp-blocks/block-editor-playground/blob/main/LICENSE.md
 * Text Domain:       issue
 *
 * @package Remembr
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function remembr_blocks_init() {
	register_block_type( __DIR__ . '/build/issue/' );
	register_block_type( __DIR__ . '/build/score/' );
}
add_action( 'init', 'remembr_blocks_init' );
