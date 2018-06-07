<?php

add_shortcode( 'hpat_shortcode', 'hpat_shortcode_handler' );

function hpat_shortcode_handler() {

	$output = "test";

	return $output;
}

add_action( 'vc_before_init', 'hpat_vc_shortcodes' );

function hpat_vc_shortcodes() {
	vc_map( array(
		"name" => __( "Hpat Shortcode", "theme-slug" ),
		"base" => "hpat_shortcode",
		"class" => "",
		//"category" => __( "Content", "my-text-domain"),
		//'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
		"params" => array()
	) );
}

function bartag_func( $atts ) {
	$atts = shortcode_atts(
		array(
			'foo' => 'no foo',
			'bar' => 'default bar',
		), $atts, 'bartag' );

	return 'bartag: ' . $atts['foo'] . ' ' . $atts['bar'];
}
add_shortcode( 'bartag', 'bartag_func' );

function wporg_shortcode($atts = [], $content = null)
{
    // do something to $content
 
    // run shortcode parser recursively
    $content = do_shortcode($content);
 
    // always return
    return $content;
}
add_shortcode('wporg', 'wporg_shortcode');
