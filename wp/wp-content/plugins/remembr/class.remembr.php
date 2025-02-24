<?php

class Remembr {
	public static function init() {

		load_plugin_textdomain('remembr', false, 'remembr/languages');
		// load_plugin_textdomain('remembr', 'wp-content/plugins/remembr/languages');

		register_block_type( REMEMBR__PLUGIN_DIR . 'blocks/issue/' );
		register_block_type( REMEMBR__PLUGIN_DIR . 'blocks/score/' );
	}

	public static function plugin_activation() {
		if ( version_compare( $GLOBALS['wp_version'], REMEMBR__MINIMUM_WP_VERSION, '<' ) ) {
			$message = '<strong>' .
				/* translators: 1: Current RemembR version number, 2: Minimum WordPress version number required. */
				sprintf( esc_html__( 'RemembR %1$s requires WordPress %2$s or higher.', 'RemembR' ), REMEMBR_VERSION, REMEMBR__MINIMUM_WP_VERSION ) . '</strong> ';

			self::bail_on_activation( $message );
		} elseif ( ! empty( $_SERVER['SCRIPT_NAME'] ) && false !== strpos( $_SERVER['SCRIPT_NAME'], '/wp-admin/plugins.php' ) ) {
			add_option( 'remembr_activated', true );
			require_once REMEMBR__PLUGIN_DIR . 'class.remembr-data.php';
			Remembr_Data::install();
		}
	}

	public static function plugin_deactivation() {
		require_once REMEMBR__PLUGIN_DIR . 'class.remembr-data.php';
		Remembr_Data::uninstall();
		delete_option( 'remembr_activated');
	}
	
	private static function bail_on_activation( $message ) {
		?>
<!doctype html>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<style>
* {
	text-align: center;
	margin: 0;
	padding: 0;
	font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
}
p {
	margin-top: 1em;
	font-size: 18px;
}
</style>
</head>
<body>
<p><?php echo esc_html( $message ); ?></p>
</body>
</html>
		<?php
		exit;
	}
}
