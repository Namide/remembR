<?php
/*
Plugin Name: RemembR
Plugin URI: https://github.com/Namide/remembR
Description: Spaced repetition tool.
Version: 0.0.1
Requires PHP: 8.0.0
Author: Namide
Author URI: https://damien-doussaud.com/
License: GPLv3
Text Domain: remembR
*/

if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'REMEMBR_VERSION', '0.0.1' );
define( 'REMEMBR__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'REMEMBR__MINIMUM_WP_VERSION', '6.7' );

register_activation_hook( __FILE__, array( 'Remembr', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Remembr', 'plugin_deactivation' ) );

require_once REMEMBR__PLUGIN_DIR . 'class.remembr.php';

add_action( 'init', array( 'Remembr', 'init' ) );


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_blocks() {
	register_block_type( __DIR__ . '/blocks/issue/' );
	register_block_type( __DIR__ . '/blocks/score/' );
}
add_action( 'init', 'create_blocks' );