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
