<?php
/**
 * Responsible for People custom post type functionality
 */

/**
 * Modifies the rewrite rules for the People
 * custom post type
 * @author Jim Barnes
 * @since 3.10.0
 * @param array $args The argument array
 * @return array
 */
function modify_people_post_type_args( $args ) {
	$args['rewrite'] = array(
		'slug'       => 'person',
		'with_front' => false
	);

	return $args;
}

add_filter( 'ucf_people_post_type_args', 'modify_people_post_type_args', 10, 1 );

/**
 * Returns an array of valid person types
 * @author Jim Barnes
 * @since 3.10.0
 * @return array
 */
function get_valid_person_types() {
	return array(
		'person',
		'faculty'
	);
}

/**
 * Updates the url for people based on the `person_type` post meta.
 * @author Jim Barnes
 * @since 3.10.0
 * @param string $link The default link value.
 * @param WP_Post $post the WP_Post object
 * @return string
 */
function modify_people_post_type_slugs( $link, $post ) {
	if ( 'person' !== $post->post_type ) {
		return $link;
	}

	$type = get_post_meta( $post->ID, 'person_type', true );
	$slug = ! empty( $type ) &&  in_array( $type, get_valid_person_types() ) ? $type : 'person';
	$link = str_replace( 'person', $slug, $link );

	return $link;
}

add_filter( 'post_type_link', 'modify_people_post_type_slugs', 10, 2 );


/**
 * Adds rewrite rules for valid person type slugs
 * @author Jim Barnes
 * @since 3.10.0
 * @return void
 */
function add_people_rewrite_rules() {
	$valid_types = get_valid_person_types();

	foreach( $valid_types as $type ) {
		// We don't want to create another rewrite for the default
		if ( $type === 'person' ) continue;

		add_rewrite_rule( "{$type}/([^/]+)/?$", 'index.php?post_type=person&name=$matches[1]', 'top' );
	}
}

add_action( 'init', 'add_people_rewrite_rules', 10, 0 );

/**
 * Unregister the People Group taxonomy for this site
 */
function remove_people_group_taxonomy() {
	unregister_taxonomy( 'people_group' );
}

add_action( 'init', 'remove_people_group_taxonomy' );


/**
 * Modifies the taxonomies assigned to the Person
 * post type for this site.
 */
function modify_person_taxonomies() {
	return array( 'colleges' );
}

add_filter( 'ucf_people_taxonomies', 'modify_person_taxonomies' );


/**
 * Returns the ID of the featured image or fallback
 * for the given Person.
 *
 * @since 3.10.0
 * @author Jo Dickson
 * @param object $obj WP_Post object for a single Person post
 * @return mixed Attachment ID, or null if neither are available
 */
function get_person_thumbnail_id( $obj ) {
	$thumbnail_id = get_post_thumbnail_id( $obj );

	if ( ! $thumbnail_id ) {
		$thumbnail_id = get_theme_mod( 'fallback_person_thumbnail' );
	}

	if ( $thumbnail_id ) {
		$thumbnail_id = intval( $thumbnail_id );
	}

	return $thumbnail_id;
}


/**
 * Returns the featured image or a fallback for the
 * given Person.
 *
 * @since 3.10.0
 * @author Jo Dickson
 * @param object $obj WP_Post object for a single Person post
 * @param string $thumbnail_size Thumbnail size to use for the returned image
 * @param array $attr Additional arguments to pass to `wp_get_attachment_image()`
 * @return string <img> HTML tag
 */
function get_person_thumbnail( $obj, $thumbnail_size='medium', $attr ) {
	$thumbnail_id = get_person_thumbnail_id( $obj );
	$thumbnail    = '';

	if ( $thumbnail_id ) {
		$thumbnail = wp_get_attachment_image( $thumbnail_id, $thumbnail_size, false, $attr );
	}

	return $thumbnail;
}


/**
 * REST API callback function that returns thumbnail details
 * for a single person
 *
 * @since 3.10.0
 * @author Jo Dickson
 * @param array $data Array of single feed object data
 * @param string $field_name Name of the current field (in this case, 'thumbnails')
 * @param object $request WP_REST_Request object; contains details about the current request
 * @return mixed Image URL string or null
 */
function get_person_thumbnail_rest_callback( $data, $field_name, $request ) {
	$thumbnail_id      = get_person_thumbnail_id( $data['id'] );
	$details_thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );

	return array(
		'thumbnail' => array(
			'src'    => $details_thumbnail[0],
			'width'  => $details_thumbnail[1],
			'height' => $details_thumbnail[2]
		)
	);
}


/**
 * REST API callback function that returns a person's job title
 *
 * @since 3.10.0
 * @author Jo Dickson
 * @param array $data Array of single feed object data
 * @param string $field_name Name of the current field (in this case, 'person_title')
 * @param object $request WP_REST_Request object; contains details about the current request
 * @return mixed Job title string or null
 */
function get_person_title_rest_callback( $data, $field_name, $request ) {
	return get_field( 'person_title', $data['id'] );
}


/**
 * Registers custom fields in REST API results for people.
 *
 * @since 3.10.0
 * @author Jo Dickson
 */
function add_person_feed_data() {
	register_rest_field( 'person', 'thumbnails',
		array(
			'get_callback' => 'get_person_thumbnail_rest_callback',
			'schema'       => null,
		)
	);

	register_rest_field( 'person', 'person_title',
		array(
			'get_callback' => 'get_person_title_rest_callback',
			'schema'       => null,
		)
	);
}

add_action( 'rest_api_init', 'add_person_feed_data' );


/**
 * Returns the permalink of the page assigned as
 * the Faculty Search page in the Customizer.
 *
 * @since 3.10.0
 * @author Jo Dickson
 * @return string
 */
function get_faculty_search_page_url() {
	$faculty_search_pg_path = untrailingslashit( get_theme_mod_or_default( 'faculty_search_page_path' ) );
	$faculty_search_pg      = $faculty_search_pg_path ? get_page_by_path( $faculty_search_pg_path ) : null;
	$faculty_search_url     = $faculty_search_pg ? get_permalink( $faculty_search_pg ) : '';

	return $faculty_search_url;
}
