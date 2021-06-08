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
		'slug'       => 'faculty',
		'with_front' => false
	);

	return $args;
}

add_filter( 'ucf_people_post_type_args', 'modify_people_post_type_args', 10, 1 );


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
