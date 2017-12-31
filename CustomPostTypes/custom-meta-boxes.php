<?php

add_action( 'add_meta_boxes', 'hpat_meta_boxes_init' );

function hpat_meta_boxes_init() {
    
    add_meta_box( 'hpat-task-meta', 'Task Information', 
                'hpat_task_meta_box', 'tasks', 'normal', 'default');
}

function hpat_task_meta_box( $post, $box ) {
    
    $hpat_task_state = get_post_meta( $post->ID, '_hpat_task_state', true );
    $hpat_project_slug = get_post_meta( $post->ID, '_hpat_project_slug', true );
    $hpat_projects = hpat_get_custom_post_array('projects');
            
    wp_nonce_field( plugin_basename( __FILE__ ), 'hpat_save_task_meta_box');
    
    echo '<p>Done: <input type="checkbox" name="hpat_task_state"';
    if( $hpat_task_state == 'on' ){ 
        echo 'checked '; 
    }
    echo '/></p>'; 
    echo '<p>Project: <select name="hpat_project_slug">';
    foreach ($hpat_projects as $hpat_project) {
        echo '<option value="' . $hpat_project[slug] . '" ' . selected( $hpat_project_slug, $hpat_project[slug], false ) . '>' . $hpat_project[title] . '</option>';
    }
    echo '</select>';
}

add_action( 'save_post', 'hpat_save_task_meta_box' );

function hpat_save_task_meta_box( $post_id ) {
    
                
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    wp_verify_nonce( plugin_basename( __FILE__ ), 'hpat_save_task_meta_box' );
    
    if( isset( $_POST['hpat_task_state'] ) ) {
        update_post_meta( $post_id, '_hpat_task_state', 'on' );
    }
    else {
        update_post_meta( $post_id, '_hpat_task_state', '' );
    }
    
    if( isset( $_POST['hpat_project_slug'] ) ) {
        update_post_meta( $post_id, '_hpat_project_slug', $_POST['hpat_project_slug'] );
    }
}

?>
