<?php 

function function_name( $params ) {
	return 'bar';
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
