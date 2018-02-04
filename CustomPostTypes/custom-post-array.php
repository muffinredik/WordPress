<?php

function hpat_get_custom_post_array( $custom_post = 'post' ) {
    
    $custom_posts = array();
    
    $args = array (
        'post_type' => $custom_post,
        'order' => 'ASC',
    );
    
    $custom_post_query = new WP_Query( $args );
    
    while ( $custom_post_query -> have_posts() ) {
        
        $custom_post_query -> the_post();
        array_push($custom_posts, array( 'slug'     => basename( get_permalink() ), 
                                                      'title'    => get_the_title() ) );
    }
    wp_reset_postdata();
    
    return $custom_posts;
}
