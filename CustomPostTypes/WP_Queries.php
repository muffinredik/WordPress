<?php

// get posts afer now
$args = array (
  'post_type' => 'dl_events',
  'order' => 'ASC',
  'orderby' => 'meta_value',
  'meta_key' => 'wpcf-datum_anfang',
  'posts_per_page' => '-1',
  'meta_query' => array( 
    array(
      'key' => 'wpcf-datum_anfang', 
      'value' => current_time('U'), 
      'compare' => '>=', 
      'type' => 'NUMERIC' 
    )
  ),
);
