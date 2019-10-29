<?php

$admin_page = add_submenu_page( NULL, __( 'Ninja Forms Processing', 'ninja-forms' ), __( 'Processing', 'ninja-forms' ), apply_filters( 'ninja_forms_admin_menu_capabilities', 'manage_options' ), 'nf-processing', 'nf_output_step_processing_page' );

// Ninja Forma Capabilities for User
add_filter( 'ninja_forms_admin_menu_capabilities',  'dl_replace_nf_admin_capability', 10, 1 );
add_filter( 'ninja_forms_admin_parent_menu_capabilities',  'dl_replace_nf_admin_capability', 10, 1 );
add_filter( 'ninja_forms_admin_all_forms_capabilities',  'dl_replace_nf_admin_capability', 10, 1 );
add_filter( 'ninja_forms_admin_submissions_capabilities',  'dl_replace_nf_admin_capability', 10, 1 );

function dl_replace_nf_admin_capability( $capability ) {
  $capability = 'edit_posts';
  return $capability;
}

/*
Alle Hooks: 
Forms – ninja_forms_admin_parent_menu_capabilities
All Forms – ninja_forms_admin_all_forms_capabilities
Submissions – ninja_forms_admin_submissions_capabilities
Import/Export – ninja_forms_admin_import_export_capabilities
Settings – ninja_forms_admin_settings_capabilities
Get Help – ninja_forms_admin_status_capabilities
Add-Ons – ninja_forms_admin_extend_capabilities
*/

// Ninja Forms Add Attachments
add_filter( 'ninja_forms_action_email_attachments', function( $attachments, $data, $settings ) {

	if ($data['form_id'] == 8) {
		// Append file path.
		$attachments[] = '_path_tp_file_';
		return $attachments;
	}
}, 10, 3 );

// Ninja Forms Change Fields
add_filter( 'ninja_forms_render_options', 'dl_nf_forms_render_options', 10, 2 );

function dl_nf_forms_render_options( $options, $settings ) {

	if ( 'veranstaltung_1572269664876' == $settings[ 'key' ] ) {
		$options = array();
		$events = dl_get_events(); // array of custom post types
		foreach ( $events as $event ) {
			$time = date( 'H:i', $event['start_date'] );
			$start_date = $time == '00:00' ? date("d.m.Y", $event['start_date']) : date("d.m.Y H:i", $event['start_date']);
			$title = $start_date . ' - ' . $event['title'];
			$slug = preg_replace('/\W+/', '-', strtolower( $title ) );
			array_push( $options, [
				'label' => $start_date . ' - ' . $event['title'],
				'value' => $slug,
				'calc'  => 0,
				'selected' => is_admin() ? false : true,
			] );
		}

		// If viewing a submission get the submitted value in case it is no longer an option in the form.
		if ( is_admin() && array_key_exists( 'post', $_GET ) ) {
			$post_id = absint( $_GET[ 'post' ] );
			$selected_value = get_post_meta( $post_id, '_field_' . $settings[ 'order' ], true );

			// Check whether the selected value is already in $options (either part of the form or added above).
			$key = array_search( $selected_value, array_column( $options, 'value' ) );
			// Only add the selected value if it's not present.
			if ( false === $key ) {
				$options[] = [
					'label' => $selected_value,  // The original display label is not available.
					'value' => $selected_value,
					'calc' => 0,
					'selected' => true,
				];
			}
		}
	}
	return $options;
}

