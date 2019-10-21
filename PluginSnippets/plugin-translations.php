<?php

function dl_plugin_load_plugin_textdomain() {
	load_plugin_textdomain( 'dl-plugin', FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'dl_plugin_load_plugin_textdomain' );
