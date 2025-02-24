<?php
/*
Plugin Name: RemembR
Plugin URI: https://github.com/Namide/remembr
Description: Spaced repetition tool.
Version: 0.0.1
Requires PHP: 8.0.0
Author: Namide
Author URI: https://damien-doussaud.com/
License: GPLv3
Text Domain: remembr
*/


if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'REMEMBR_VERSION', '0.0.1' );
define( 'REMEMBR__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'REMEMBR__MINIMUM_WP_VERSION', '6.7' );

require_once REMEMBR__PLUGIN_DIR . 'class.remembr.php';

register_activation_hook( __FILE__, array( 'Remembr', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Remembr', 'plugin_deactivation' ) );
add_action( 'init', array( 'Remembr', 'init' ) );


// function initialize_plugin() {
// 	load_plugin_textdomain( 'remembr', false, 'remembr/languages/' );
// }
// add_action( 'plugins_loaded', 'initialize_plugin' );