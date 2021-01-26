<?php 

// Shortcode
add_shortcode( 'dl-year', 'dl_year_handler' );

function dl_year_handler() {
	return date( 'Y' );
}

// Shortcode mit Parametern
add_shortcode( 'dl-year', 'dl_year_handler' );

function dl_year_handler( $atts ) {

	// Default Values
	$atts = shortcode_atts(
			array(
				'credit' => 'by Dominik Liss',
		), $atts );

	return date( 'Y' ) . ' - ' . $atts['credit'];
}
