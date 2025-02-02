<?php

class Remembr_Data {
	private static function get_table_name() {
		global $wpdb;
		$table_name = $wpdb->prefix . "remembr";
		return $table_name;
	}
	
	public static function install() {
		global $wpdb;
		$table_name = self::get_table_name();
		$charset_collate = $wpdb->get_charset_collate();

		// https://developer.wordpress.org/plugins/creating-tables-with-plugins/
		$sql = "CREATE TABLE $table_name (
			-- id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			user_id bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			post_id bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			next_poke datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			poke_state int(11) UNSIGNED NOT NULL DEFAULT 0,
			CONSTRAINT pk_user_post PRIMARY KEY (user_id, post_id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		return dbDelta( $sql );
	}
	
	public static function uninstall() {
		global $wpdb;
		$table_name = self::get_table_name();
		$sql = "DROP TABLE $table_name;";
		$wpdb->query($sql);
	}
}
