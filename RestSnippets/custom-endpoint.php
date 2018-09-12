<?php 

function function_name( $params ) {
	$parameters = $request_data->get_params();
    	$id = $parameters['id'];
    	return json_encode(get_dsgvo_infos_by_id($id));
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'base/v1', 'site', array(
		'methods' => 'GET',
		'callback' => 'function_name',
	) );
} );

add_filter( 'rest_authentication_errors', function(){
	wp_set_current_user( 1 ); // replace with the ID of a WP user with the authorization you want
}, 101 );

?>
