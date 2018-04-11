<?php

add_shortcode( 'mwd-dsgvo', 'mwd_dsgvo_main_shortcode_handler' );

function mwd_dsgvo_main_shortcode_handler( $atts, $content = null )	{

	$sections = mwd_dsgvo_get_custom_table_entries( 'mwd_dsgvo_sections' );
	$generalSettings = mwd_dsgvo_get_general_settings ();

	$output = '<div id="mwd-dsgvo-general-settings"><p>';
	foreach ( $generalSettings as $setting ) {
		$output .= '
			<span>' . $setting['value'] . '</span><br />
		';
	}
	$output .= '</p></div>';

	$output .= '<div id="mwd-dsgvo-sections">';
	foreach ( $sections as $section ) {
		if ( $section['active'] == 0 ) continue;
		$output .= '
		<div class="' . $section['slug'] . '">
			<h2>' . $section['title'] . '</h2>
			<p>' . $section['text'] . '</p>
			<p>' . $section['additionaltext'] . '</p>
		</div>
		';
	}
	$output .= '</div>';

	return $output;
}

add_action( 'vc_before_init', 'mwd_vc_shortcodes' );

function mwd_vc_shortcodes() {
	vc_map( array(
		"name"      => __( "Medani DSGVO", "mwd-dsgvo" ),
		"base"      => "mwd-dsgvo",
		"class"     => "",
		"icon"      => plugin_dir_url(__FILE__) . '../assets/medani_logo.png',
		//"category" => __( "Content", "my-text-domain"),
		//'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
		//'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
		"params"    => array()
	) );
}

add_shortcode( 'mwd-firmenname', 'mwd_dsgvo_general_setting_handler' );

function mwd_dsgvo_general_setting_handler( $atts, $content = null, $tag ) {

	$shortcodesSettingsMap = mwd_dsgvo_get_shortcodes_settings_map();
	$generalSettingKey = $shortcodesSettingsMap[$tag];

	return get_option( $generalSettingKey );

}



