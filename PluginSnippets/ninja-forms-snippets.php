<?php

// Ninja Forma Capabilities for User
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
