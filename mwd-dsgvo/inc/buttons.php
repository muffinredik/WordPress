<?php

/*function medani_mce_button() {
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'medani_tinymce_plugin' );
        add_filter( 'mce_buttons', 'medani_register_mce_button' );
    }
}
add_action('admin_head', 'medani_mce_button');

function medani_tinymce_plugin( $plugin_array ) {
    $plugin_array['medani_mce_button'] = plugin_dir_url(__FILE__) . 'buttons.js';
    return $plugin_array;
}

function medani_register_mce_button( $buttons ) {
    array_push( $buttons, 'medani_mce_button' );
    return $buttons;
}*/

?>