<?php

add_action('admin_enqueue_scripts', 'enque_scripts_and_styles');

function enque_scripts_and_styles() {
    wp_enqueue_style( 'mwd-dsgvo-style', plugin_dir_url(__FILE__) . '../style.css', array() );
    wp_enqueue_script( 'medani-dsgvo-functions', plugin_dir_url(__FILE__) . '../js/functions.js', array ( 'jquery' ), 1.0, true );
}

?>
