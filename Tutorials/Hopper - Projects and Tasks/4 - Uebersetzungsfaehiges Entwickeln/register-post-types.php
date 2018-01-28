<?php 

add_action( 'init', 'hpat_register_post_types' );

function hpat_register_post_types() {
    
    $labels = array(
        'name'                  => __('Projects', 'hopper-projects-and-tasks'),
        'singular_name'         => __('Project', 'hopper-projects-and-tasks'),
        'add_new'               => __('Add New Project', 'hopper-projects-and-tasks'),
        'add_new_item'          => __('Add New Project', 'hopper-projects-and-tasks'),
        'edit_item'             => __('Edit Project', 'hopper-projects-and-tasks'),
        'new_item'              => __('New Project', 'hopper-projects-and-tasks'),
        'all_items'             => __('All Projects', 'hopper-projects-and-tasks'),
        'view_items'            => __('View Projects', 'hopper-projects-and-tasks'),
        'search_items'          => __('Search Projects', 'hopper-projects-and-tasks'),
        'not_found'             => __('No projects found', 'hopper-projects-and-tasks'),
        'not_found_in_trash'    => __('No projects found in trash', 'hopper-projects-and-tasks'),
        'menu_name'             => __('Projects', 'hopper-projects-and-tasks'),
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
    
    $labels = array(
        'name'                  => __('Tasks', 'hopper-projects-and-tasks'),
        'singular_name'         => __('Task', 'hopper-projects-and-tasks'),
        'add_new'               => __('Add New Task', 'hopper-projects-and-tasks'),
        'add_new_item'          => __('Add New Task', 'hopper-projects-and-tasks'),
        'edit_item'             => __('Edit Task', 'hopper-projects-and-tasks'),
        'new_item'              => __('New Task', 'hopper-projects-and-tasks'),
        'all_items'             => __('All Tasks', 'hopper-projects-and-tasks'),
        'view_items'            => __('View Tasks', 'hopper-projects-and-tasks'),
        'search_items'          => __('Search Tasks', 'hopper-projects-and-tasks'),
        'not_found'             => __('No tasks found', 'hopper-projects-and-tasks'),
        'not_found_in_trash'    => __('No tasks found in trash', 'hopper-projects-and-tasks'),
        'menu_name'             => __('Tasks', 'hopper-projects-and-tasks'),
    );
    
    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'taxonomies'    => array( 'category' ),
        'rewrite'       => array( 'slug' => 'task' ),
        'supports'      => array( 'title' ),
    );
    
    register_post_type( 'tasks', $args );
}
?>
