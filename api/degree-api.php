<?php
/**
 * Add REST API support to an already registered post type.
 */
function add_degree_endpoint() {
	global $wp_post_types;
	
	//be sure to set this to the name of your post type!
	$post_type_name = 'degree';
	if( isset( $wp_post_types[ $post_type_name ] ) ) {
		$wp_post_types[$post_type_name]->show_in_rest = true;
		// Optionally customize the rest_base or controller class
		$wp_post_types[$post_type_name]->rest_base = 'degrees';
		$wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
	}
}

add_action( 'init', 'add_degree_endpoint', 99 );

function add_rest_fields() {
	$taxonomies = get_object_taxonomies( 'degree' );

	foreach( $taxonomies as $tax ) {
		register_rest_field( 'degree',
			$tax,
			array(
				'get_callback'    => 'degree_rest_get_taxonomies',
				'update_callback' => null,
				'schema'          => null
			)
		);
	}

	register_rest_field( 'degree',
		'degree_meta',
		array(
			'get_callback'    => 'degree_rest_get_termmeta',
			'update_callback' => null,
			'schema'          => null
		)
	);
}

add_action( 'rest_api_init', 'add_rest_fields', 99 );

/**
 * Gets all terms set to the post for the provided taxonomy
 * @author Jim Barnes
 * @since 0.0.1
 * @param $object array | The data object that will be returned to the Rest API
 * @param $tax string | The field name, which is this case should be a taxonomy slug
 * @param $request array | The request object, which includes get and post parameters
 * @return mixed | In this case a WP_Term object.
 **/
function degree_rest_get_taxonomies( $object, $tax, $request ) {
	$terms = wp_get_post_terms( $object['id'], $tax );
	foreach( $terms as $term ) {
		$meta = get_term_meta( $term->term_id );

		foreach( $meta as $key=>$val ) {
			if ( count( $val ) === 1 ) {
				$meta[$key] = $val[0];
			} 
		}

		$term->meta = $meta;
	}
	return $terms;
}

/**
 * Adds the postmeta to the `meta` field.
 * @author Jim Barnes
 * @since 1.0.1
 * @param $object array | The data object that will be returned to the Rest API
 * @param $field_name string | The field name
 * @param $request array | The request object, which includes get and post parameters
 * @return mixed | In this case an array of postmeta.
 **/
function degree_rest_get_termmeta( $object, $field_name, $request ) {
	$retval = array();
	$postmeta = get_post_meta( $object['id'] );
	foreach( $postmeta as $key => $val ) {
		if ( substr( $key, 0, 6 ) === 'degree' ) {
			$retval[$key] = $val[0];
		}
	}
	return $retval;
}

/** 
 * Adds meta_key and meta_value to allowed query args
 * @author Jim Barnes
 * @since 2.3.16
 * @param $valid_args Array | The array of valid argument names
 * @return Array | The array of valid argument names
 **/
function allow_meta_query( $valid_vars ) {
	
	$valid_vars = array_merge( $valid_vars, array( 'meta_key', 'meta_value' ) );
	return $valid_vars;
}

add_filter( 'rest_query_vars', 'allow_meta_query', 10, 1 );

/**
 * Processes the meta_key and meta_value args
 * @author Jim Barnes
 * @since 2.3.16
 * @param $args Array | The array of arguments for WP_Query
 * @param $request Array | The request array, including GET params
 * @return Array | The argument array
 **/
function rest_meta_query( $args, $request ) {
	if ( isset( $request['meta_key'] ) && isset( $request['meta_value'] ) ) {
		$args['meta_query'] = array(
			array(
				'key'   => $request['meta_key'],
				'value' => $request['meta_value']
			)
		);
	}

	return $args;
}

add_filter( 'rest_degree_query', 'rest_meta_query', 10, 2 );