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
 * Returns the featured image or a fallback for the
 * given Person.
 *
 * @since 3.10.0
 * @author Jo Dickson
 * @param object WP_Post object for a single Person post
 * @param string $thumbnail_size Thumbnail size to use for the returned image
 * @param array $attr Additional arguments to pass to `get_the_post_thumbnail()` or `wp_get_attachment_image()`.
 * @return string <img> HTML tag
 */
function get_person_thumbnail( $obj, $thumbnail_size='medium', $attr ) {
	$thumbnail = get_the_post_thumbnail( $obj, $thumbnail_size, $attr );

	if ( ! $thumbnail ) {
		$fallback_id = get_theme_mod( 'fallback_person_thumbnail' );
		if ( $fallback_id ) {
			$thumbnail = wp_get_attachment_image( $fallback_id, $thumbnail_size, false, $attr );
		}
	}

	return $thumbnail;
}


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
