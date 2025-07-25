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
		'slug'       => 'expert',
		'with_front' => false
	);

	return $args;
}

add_filter( 'ucf_people_post_type_args', 'modify_people_post_type_args', 10, 1 );


/**
 * Builds the person's title using the built-in fields
 * @author Jim Barnes
 * @since 3.27.0
 * @param WP_Post $post The Person post
 * @return string
 */
function mainsite_get_person_name( $post ) {
	if ( ! $post->post_type == 'person' ) { return; }
	$prefix = get_field( 'person_title_prefix', $post->ID ) ?: '';
	$suffix = get_field( 'person_title_suffix', $post->ID ) ?: '';
	if ( $prefix ) {
		$prefix = trim( $prefix ) . ' ';
	}
	if ( $suffix && substr( $suffix, 0, 1 ) !== ',' ) {
		$suffix = ' ' . trim( $suffix );
	}
	return wptexturize( $prefix . $post->post_title . $suffix );
}

/**
 * Modifies the post_types array for the expertise
 * custom taxonomy.
 * @author Jim Barnes
 * @since 3.17.0
 * @param array $post_types The unmodified post_type array
 * @return array
 */
function modify_expertise_objects( $post_types ) {
	$post_types[] = 'person';
	return $post_types;
}

add_filter( 'ucf_expertise_taxonomy_objects', 'modify_expertise_objects', 10, 1 );



/**
 * Modifies the taxonomies assigned to the Person
 * post type for this site.
 */
function modify_person_taxonomies() {
	return array( 'colleges', 'post_tag' );
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
function get_person_titles_rest_callback( $data, $field_name, $request ) {
	$titles = array();
	$title_rows = get_field( 'person_titles', $data['id'] );
	if ( $title_rows ) {
		foreach ( $title_rows as $title_row ) {
			$titles[] = $title_row['job_title'];
		}
	}
	return $titles;
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

	register_rest_field( 'person', 'person_titles',
		array(
			'get_callback' => 'get_person_titles_rest_callback',
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

/**
 * Builds the additional contribution string
 *
 * @author Jim Barnes
 * @since 3.0.1
 * @param  array $work The array of works. Could be books, articles, awards, etc.
 * @return void
 */
function get_additional_contributors_markup( $work ) {
	$retval = '';

	if ( is_array( $work['additional_contributors'] ) && count( $work['additional_contributors'] ) > 0 ) {
		$authors = [];

		foreach( $work['additional_contributors'] as $author ) {
			$permalink = get_permalink( $author );
			$name = $author->post_title;
			$authors[] = "<a href=\"$permalink\">$name</a>";
		}

		$retval = "<br><span class=\"small text-muted\">(UCF Research Partners: " . implode( ', ', $authors ) . ')</span>';
	}

	return $retval;
}

function enqueue_expert_section_scripts() {
	$obj = get_queried_object();

	if ( $obj && $obj->post_type === 'person' ) {
		$theme = wp_get_theme();
		$theme_version = $theme->get( 'Version' );

		// Get the section to be added
		$section_id = get_theme_mod( 'expert_profile_closing_section' );
		if ( ! $section_id ) return;

		$css_file_id = get_field( 'ucf_section_stylesheet', $section_id );
		$js_file_id = get_field( 'ucf_section_javascript', $section_id );

		if ( $css_file_id ) {
			$css_url = wp_get_attachment_url( $css_file_id );
			if ( $css_url ) {
				wp_enqueue_style( "expert-profile-section-style-$css_file_id", $css_url, array( 'style' ), $theme_version );
			}
		}

		if ( $js_file_id ) {
			$js_url = wp_get_attachment_url( $js_file_id );
			if ( $js_url ) {
				wp_enqueue_script( "expert-profile-section-style-$js_file_id", $js_url, array( 'script' ), $theme_version, true );
			}
		}

	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_expert_section_scripts', 10, 0 );
