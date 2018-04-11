<?php

add_action( 'admin_menu', 'mwd_dsgvo_update_settings' );

function mwd_dsgvo_update_settings() {

	if ( !current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized user' );
	}

	if ( !isset( $_POST['option_page'] ) || !isset( $_POST['_wp_nonce'] ) ) {
		return;
	}

	if ( !wp_verify_nonce( $_POST['_wp_nonce'], 'mwd_dsgvo_settings_page' ) ) {
		wp_die( 'Nonce is invalid' );
	}

	if( isset( $_POST['mwd_dsgvo_version_id'] ) && isset( $_POST['mwd_dsgvo_version_confirmation'] ) ) {
		global $wpdb;
		$versions_table_name = $wpdb->prefix . 'mwd_dsgvo_versions';
		$version = $wpdb->get_results( $wpdb->prepare("SELECT * FROM {$versions_table_name} WHERE id = %d", $_POST['mwd_dsgvo_version_id']) );
		$version = map_to_array( $version[0] );
		$variables = unserialize( $version['content'] );

		foreach( $variables as $key=>$value ) {
			if ( $key == 'mwd_dsgvo_version_id' ) continue;
			$_POST[$key] = $value;
		}
	}

	if( isset($_POST['option_page']) ) {
		if( $_POST['option_page'] != 'mwd-dsgvo') return;
		$generalSettings = get_general_settings();
		$sectionsEntries = get_section_entries();
		if( !isset( $_POST['mwd_dsgvo_version_confirmation'] ) ) {
			add_new_version();
			update_or_add_general_settings( $generalSettings );
			update_or_add_sections( $sectionsEntries );
		}
		else {
			update_or_add_general_settings( $generalSettings, true );
			update_or_add_sections( $sectionsEntries, true );
			$versions = mwd_dsgvo_get_custom_table_entries( 'mwd_dsgvo_versions' );
			foreach ( $versions as $version ) {
				if ( $version['id'] ==  $_POST['mwd_dsgvo_version_id'] ) {
					$_POST['mwd-dsgvo-version-date'] = $version['created'];
				}
			}
		}
	}
}

function get_general_settings() {
	$generalSettings = array();
	foreach ( $_POST as $key => $value ) {
		if ( strpos( $key, 'mwd_dsgvo_general_settings' ) !== false ) {
			array_push( $generalSettings, array(
				'key'   => $key,
				'value' => wp_kses_post( $value )
			));
		}
	}
	return $generalSettings;

}

function update_or_add_general_settings( $general_settings, $use_temp_table = false ) {

	if ( $use_temp_table ) {
		global $wpdb;
		$temp_general_settings_table_name = $wpdb->prefix . 'mwd_dsgvo_temp_general_settings';
		$wpdb->query( "TRUNCATE TABLE $temp_general_settings_table_name" );
	}

	foreach ( $general_settings as $setting ) {
		if ( $use_temp_table ) {
			$key = $setting['key'];
			$value = $setting['value'];

			$updateValue = array( 'value' => $value );
			$where = array( 'keyid' => $key );
			$insertValue = array(
				'keyid'          => $key,
				'value'     => $value
			);

			mwd_dsgvo_add_or_update_custom_table_entry(
				$wpdb->prepare("SELECT * FROM {$temp_general_settings_table_name} WHERE keyid = %s", $key),
				$temp_general_settings_table_name,
				$updateValue,
				$insertValue,
				$where
			);
		}
		else {
			update_option( $setting['key'], $setting['value'] );
		}
	}
}

function get_section_entries() {
	$sectionsEntries = array();
	foreach ( $_POST as $key => $value ) {
		if ( strpos($key, 'mwd_dsgvo_sections') !== false ) {
			$keyParts =  explode( '_', $key );
			$sectionSlug = $keyParts[3];
			$columnName = $keyParts[4];
			//$value = handle_datatypes( $value, $columnName );
			array_push( $sectionsEntries, array(
				'slug'          => $sectionSlug,
				'columnName'    => $columnName,
				'value'         => wp_kses_post( $value )
			));
		}
	}
	return $sectionsEntries;
}

function update_or_add_sections( $sectionsEntries, $use_temp_table = false ) {

	global $wpdb;

	if ( $use_temp_table ) {
		$sections_table_name = $wpdb->prefix . 'mwd_dsgvo_temp_sections';
		$wpdb->query( "TRUNCATE TABLE $sections_table_name" );
	}
	else {
		$sections_table_name = $wpdb->prefix . 'mwd_dsgvo_sections';
	}

	foreach ( $sectionsEntries as $entry ){
		$slug = $entry['slug'];
		$columnName = $entry['columnName'];
		$value = $entry['value'];

		if ( $entry['slug'] == '' ) continue;

		$updateValue = array( $columnName => $value );
		$where = array( 'slug' => $slug );
		$insertValue = array(
			'slug'          => $slug,
			$columnName     => $value
		);

		mwd_dsgvo_add_or_update_custom_table_entry(
			$wpdb->prepare("SELECT * FROM {$sections_table_name} WHERE slug = %s", $slug),
			$sections_table_name,
			$updateValue,
			$insertValue,
			$where
		);
	}
}

function add_new_version() {

	global $wpdb;

	mwd_dsgvo_do_shortcodes();
	$table = $wpdb->prefix . 'mwd_dsgvo_versions';

	$content = serialize($_POST);
	$currentUser = wp_get_current_user();

	$insertValue = array(
		'created'   => date('Y-m-d H:i:s'),
		'content'   => $content,
		'userid'    => $currentUser->ID,
		'username'  => $currentUser->user_login,
	);

	$wpdb->insert( $table, $insertValue );
}

function mwd_dsgvo_do_shortcodes() {

	$shortcodesSettingsMap = mwd_dsgvo_get_shortcodes_settings_map();
	$decodedVariables = array();

	foreach ( $_POST as $key => $value ) {
		if ( strpos( strtolower( $key ), 'text' ) !== false ) {
			$decodedVariables[$key] =  mwd_dsgvo_fill_shortcodes_values( $value, $shortcodesSettingsMap );
		}
	}

	foreach ( $decodedVariables as $key => $value ) {
		$_POST[$key] = $value;
	}
}

function mwd_dsgvo_fill_shortcodes_values( $text, $shortcodesSettingsMap ) {

	foreach ( $shortcodesSettingsMap as $key => $value ) {
		if ( strpos( $text, '[' . $key . ']' ) !== false && isset( $_POST[$value] )) {
			$text = str_replace('[' . $key . ']', $_POST[$value], $text);
		}
	}
	return $text;
}

