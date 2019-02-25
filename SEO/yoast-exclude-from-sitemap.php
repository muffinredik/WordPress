<?php 

// SEO delet from Google Index (yoast)
add_action( 'wp_head', 'dl_noindex' );
function dl_noindex() {
    global $post;
	$postType = get_post_type($post);
    if ( $postType == 'tribe_events' ) {
        $date = new DateTime( get_post_meta( $post->ID,'_EventStartDate' )[0] );
	    $currentDate = new DateTime();
        if ( $currentDate > $date  ) {
	        wp_no_robots();
        }
    }
}

add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', function () {
	$posts = dl_get_post_type_array('tribe_events');
	$postIDs = array();
	$currentDate = new DateTime();
	foreach ( $posts as $event ) {
		$date = new DateTime( get_post_meta( $event->ID,'_EventStartDate' )[0] );
		if ( $currentDate > $date  ) {
			array_push( $postIDs, $event->ID );
		}
	}
	return $postIDs;
} );
