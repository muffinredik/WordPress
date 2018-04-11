<?php

function mwd_dsgvo_get_custom_table_entries( $tableNoPrefix ) {

	global $wpdb;
	$sectionsTableName = $wpdb->prefix . $tableNoPrefix;
	$sections = $wpdb->get_results( "SELECT * FROM $sectionsTableName" );
	return array_map('map_to_array', $sections);
}

function mwd_dsgvo_get_general_settings() {
	$options = wp_load_alloptions();
	$settings = array();
	foreach ($options as $slug => $value) {
		if ( strpos( $slug, 'mwd_dsgvo_general_settings' ) !== false ) {
			array_push( $settings, array(
				'slug'  => $slug,
				'value' => $value
			));
		}
	}
	return $settings;
}

function map_to_array($obj) {
	return (array)$obj;
}

function get_section_fields( $sections ) {

	global $wpdb;

	$fields = array();
	foreach ( $sections as $section ) {

		if ( $section['text'] === '' ) {
			$text = $section['defaulttext'];
		}
		else {
			$text = $section['text'];
		}

		array_push(
			$fields,
			array(
				'id'            => 'mwd_dsgvo_sections_' . $section['slug'] . '_active',
				'label'         => __('Aktiv', 'mwd-dsgvo'),
				'sectionId'     => 'mwd_dsgvo_sections_' . $section['slug'] . '_section',
				'htmlId'        => 'mwd-dsgvo-sections-' . $section['slug'] . '-active',
				'class'         => 'mwd-dsgvo-toggle-section',
				'inputType'     => 'checkbox',
				'customTable'   => $wpdb->prefix . 'mwd_dsgvo_sections',
				'customValue'   => $section['active']
			),
			array(
				'id'            => 'mwd_dsgvo_sections_' . $section['slug'] . '_title',
				'label'         => __('Titel', 'mwd-dsgvo'),
				'sectionId'     => 'mwd_dsgvo_sections_' . $section['slug'] . '_section',
				'htmlId'        => 'mwd-dsgvo-sections-' . $section['slug'] . '-title',
				'class'         => 'hidden-section-field',
				'inputType'     => 'text',
				'customTable'   => $wpdb->prefix . 'mwd_dsgvo_sections',
				'customValue'   => $section['title']
			),
			array(
				'id'            => 'mwd_dsgvo_sections_' . $section['slug'] . '_text',
				'label'         => __('Text', 'mwd-dsgvo'),
				'sectionId'     => 'mwd_dsgvo_sections_' . $section['slug'] . '_section',
				'htmlId'        => 'mwd-dsgvo-sections-' . $section['slug'] . '-text',
				'class'         => 'hidden-section-field',
				'inputType'     => 'wysiwyg',
				'customTable'   => $wpdb->prefix . 'mwd_dsgvo_sections',
				'customValue'   => $text
			),
			array(
				'id'            => 'mwd_dsgvo_sections_' . $section['slug'] . '_defaulttext',
				'label'         => __('Default Text', 'mwd-dsgvo'),
				'sectionId'     => 'mwd_dsgvo_sections_' . $section['slug'] . '_section',
				'htmlId'        => 'mwd-dsgvo-sections-' . $section['slug'] . '-defaulttext',
				'class'         => 'hidden-section-field',
				'inputType'     => 'defaulttext-button',
				'customTable'   => $wpdb->prefix . 'mwd_dsgvo_sections',
				'customValue'   => $section['defaulttext']
			)
		);
	}
	return $fields;
}

function mwd_dsgvo_add_or_update_custom_table_entry( $sql, $table, $updateValue, $insertValue, $where ) {

	global $wpdb;

	$results = $wpdb->get_results( $sql );

	if( count($results) > 0 ) {
		$wpdb->update( $table, $updateValue, $where );
	}
	else {
		$wpdb->insert( $table, $insertValue );
	}
}

function mwd_dsgvo_add_if_not_exists_custom_table_entry( $sql, $table, $insertValue ) {

	global $wpdb;

	$results = $wpdb->get_results( $sql );

	if( count($results) < 1 ) {
		$wpdb->insert( $table, $insertValue );
	}
}

function mwd_dsgvo_get_temp_general_setting ( $key ) {

	global $wpdb;
	$temp_general_settings_table_name = $wpdb->prefix . 'mwd_dsgvo_temp_general_settings';

	$results = $wpdb->get_results( $wpdb->prepare("SELECT * FROM {$temp_general_settings_table_name} WHERE keyid = %s", $key) );
	return array_map('map_to_array', $results)[0]['value'];
}

function mwd_dsgvo_get_shortcodes_settings_map() {

	$map = array (
		'mwd-firmenname'        => 'mwd_dsgvo_general_settings_company_name',
		'mwd-anschrift'         => 'mwd_dsgvo_general_settings_company_adress',
	);

	return $map;

}