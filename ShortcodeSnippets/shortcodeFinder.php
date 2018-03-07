function wpb_find_shortcodes($atts, $content=null) {
	ob_start();
	extract( shortcode_atts( array(
		'find' => '',
	), $atts ) );

	$string = $atts['find'];
	$shortcodes  = explode('|', $string);
    $output = "";

	foreach ($shortcodes as $shortcode) {
	    $output .= wpb_find_single_shortcode( $shortcode );
    }

	return $output;
}

function wpb_find_single_shortcode($shortcode) {

    $output = "";
	$args = array(
		's' => $shortcode,
	);
	$output .= '<p><strong>' . $shortcode . '</strong><br />';

	$output .= wpb_query( array(
		's' => $shortcode,
	) );

	$output .= '<strong>php Files</strong><br />';
	$themesFolder = get_template_directory();
	$output .= wpb_find_single_shortcode_in_files($shortcode, $themesFolder);
	$pluginsFolder = $themesFolder . '/../../plugins';
	$output .= wpb_find_single_shortcode_in_files($shortcode, $pluginsFolder);
	$output .= '</p>';


	return $output;
}

function wpb_query ( $args ) {
    $output = "";
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {

		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$permalink = get_the_permalink();
			if (strpos($permalink, 'shortcode') === false) {
				$output .= get_the_permalink() . '<br />';
			}
		}
	} else {
		$output .= "Sorry no posts found";
	}
	wp_reset_postdata();
	return $output;
}

function wpb_find_single_shortcode_in_files ($shortcode, $folder){
    $output = 'Searching in ' . $folder . '<br />';
	$command = "grep -r '$shortcode' $folder";
	$results = array();
	exec($command, $results);
	foreach ($results as $match) {
		$output .= wpb_query(
			array(
				'post_type' => 'page',
				'meta_key' => '_wp_page_template',
				'meta_value' => basename( explode(':', $match )[0] )
			)
		);
	}
	return $output;
}

add_shortcode('shortcodefinder', 'wpb_find_shortcodes');
