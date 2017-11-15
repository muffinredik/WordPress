<?php 

add_action( 'init', 'hpat_register_post_types' );

function hpat_register_post_types() {
    
    $labels = array(
        'name'                  => 'Projects',
        'singular_name'         => 'Project',
        'add_new'               => 'Add New Project',
        'add_new_item'          => 'Add New Project',
        'edit_item'             => 'Edit Project',
        'new_item'              => 'New Project',
        'all_items'             => 'All Projects',
        'view_items'            => 'View Projects',
        'search_items'          => 'Search Projects',
        'not_found'             => 'No projects found',
        'not_found_in_trash'    => 'No projects found in trash',
        'menu_name'             => 'Projects',
    );
    
    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'taxonomies'    => array( 'category' ),
        'rewrite'       => array( 'slug' => 'project' ),
        'supports'      => array( 'title' ),
    );
    
    register_post_type( 'projects', $args );
}

?>
