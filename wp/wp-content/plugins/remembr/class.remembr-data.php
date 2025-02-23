<?php

class Remembr_Data {
	/**
	 * Question response table name
	 */
	private static function get_table_qr_name() {
		global $wpdb;
		$table_name = $wpdb->prefix . "remembr_question_response";
		return $table_name;
	}

	private static function get_table_sr_name() {
		global $wpdb;
		$table_name = $wpdb->prefix . "remembr_spaced_repetition";
		return $table_name;
	}
	
	public static function install() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		
		$table_name = self::get_table_qr_name();
		$sql = "CREATE TABLE $table_name (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			post_id bigint(20) UNSIGNED NOT NULL,
			question LONGTEXT,
			response LONGTEXT,
			PRIMARY KEY (`id`),
			INDEX (`id`)
		) $charset_collate;";
		dbDelta( $sql );

		// https://developer.wordpress.org/plugins/creating-tables-with-plugins/
		$table_name = self::get_table_sr_name();
		$sql = "CREATE TABLE $table_name (
			user_id bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			qr_id bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			next_poke datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			current_loop tinyint UNSIGNED NOT NULL DEFAULT 0,
			history JSON NOT NULL DEFAULT [],
			CONSTRAINT pk_user_post PRIMARY KEY (`user_id`, `qr_id`),
			INDEX (`user_id`),
			INDEX (`next_poke`)
		) $charset_collate; ";
		return dbDelta( $sql );
	}
	
	public static function uninstall() {
		global $wpdb;

		$table_name = self::get_table_qr_name();
		$sql = "DROP TABLE $table_name; ";
		$wpdb->query($sql);

		$table_name = self::get_table_sr_name();
		$sql = "DROP TABLE $table_name; ";
		$wpdb->query($sql);
	}
}
