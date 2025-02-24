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

	public static function get_questions($post_id) {
		global $wpdb;
		$table_name = self::get_table_qr_name();
		return $wpdb->get_results( "SELECT * FROM $table_name WHERE post_id = $post_id");
	}

	public static function get_is_learning($user_id, $post_id) {
		global $wpdb;
		$table_sr_name = self::get_table_sr_name();
		$table_qr_name = self::get_table_qr_name();
		$result = $wpdb->get_results(
			"SELECT current_loop FROM $table_sr_name INNER JOIN $table_qr_name WHERE $table_sr_name.user_id = $user_id AND $table_qr_name.post_id = $post_id AND $table_sr_name.qr_id = $table_qr_name.id");
		return $result !== null && count($result) > 0;
	}

	public static function get_learning_progress_by_post($user_id, $post_id) {
		global $wpdb;
		$table_sr_name = self::get_table_sr_name();
		$table_qr_name = self::get_table_qr_name();
		$list = $wpdb->get_results(
			"SELECT current_loop FROM $table_sr_name INNER JOIN $table_qr_name WHERE $table_sr_name.user_id = $user_id AND $table_qr_name.post_id = $post_id AND $table_sr_name.qr_id = $table_qr_name.id");

		if (count($list) > 0) {
			$max = count($list) * 5;
			$total = 0;
			foreach($list as $value) {
				$total += (int) $value->current_loop;
			}
			return $total / $max;
		}

		return 0;
	}

	public static function add_questions($post_id, $question, $response) {
		global $wpdb;
		$table_name = self::get_table_qr_name();
		$data = array('post_id' => $post_id, 'question' => $question, 'response' => $response);
		$format = array('%d', '%s', '%s');
		$wpdb->insert($table_name, $data, $format);
		return $wpdb->insert_id;
	}

	public static function add_spaced_repetition($user_id, $qr_id) {
		global $wpdb;
		$table_name = self::get_table_sr_name();
		$data = array('user_id' => $user_id, 'qr_id' => $qr_id);
		$format = array('%d', '%d');
		$wpdb->insert($table_name, $data, $format);
		return $wpdb->insert_id;
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
			history JSON NOT NULL DEFAULT '[]',
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
