<?php
/**
 * Adds an endpoint for querying degrees
 **/
class Degree_API extends WP_REST_Controller {
	public function register_routes() {
		$version = 1;
		$namespace = 'ucf/v' . $version;
		$base = 'degrees';

		register_rest_route( $namespace . '/' . $base, array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( 'Degree_API', 'get_degrees' ),
				'permission_callback' => function() { return true; },
				'args'                => array(  )
			)
		) );
	}

	public function get_degrees( $request ) {
		$items = get_posts( array(
			'post_type'      => 'degree',
			'posts_per_page' => -1
		) );

		$retval = array();

		foreach( $items as $item ) {
			$retval[] = $item->post_title;
		}

		return new WP_REST_Response( $retval, 200 );
	}
}

add_action( 'rest_api_init', array( 'Degree_API', 'register_routes' ) );
