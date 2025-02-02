<?php

class Remembr {
	private static $initiated = false;

	public static function init() {
		if ( ! self::$initiated ) {
			// self::init_hooks();
		}
	}

	public static function plugin_activation() {
		if ( version_compare( $GLOBALS['wp_version'], REMEMBR__MINIMUM_WP_VERSION, '<' ) ) {
			load_plugin_textdomain( 'akismet' );

			$message = '<strong>' .
				/* translators: 1: Current Akismet version number, 2: Minimum WordPress version number required. */
				sprintf( esc_html__( 'Akismet %1$s requires WordPress %2$s or higher.', 'remembr' ), REMEMBR_VERSION, REMEMBR__MINIMUM_WP_VERSION ) . '</strong> ' .
				/* translators: 1: WordPress documentation URL, 2: Akismet download URL. */
				sprintf( __( 'Please <a href="%1$s">upgrade WordPress</a> to a current version, or <a href="%2$s">downgrade to version 2.4 of the Remembr plugin</a>.', 'remembr' ), 'https://codex.wordpress.org/Upgrading_WordPress', 'https://wordpress.org/plugins/remembr' );

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
