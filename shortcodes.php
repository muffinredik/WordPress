<?php

add_shortcode( 'mwd_landkarte', 'mwd_landkarte_handler' );

function mwd_landkarte_handler() {

	$output = "test";

	return $output;
}

add_action( 'vc_before_init', 'mwd_vc_shortcodes' );

function mwd_vc_shortcodes() {
	vc_map( array(
		"name" => __( "Medani Landkarte", "qode" ),
		"base" => "mwd_landkarte",
		"class" => "",
		//"category" => __( "Content", "my-text-domain"),
		//'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
		"params" => array()
	) );
}
