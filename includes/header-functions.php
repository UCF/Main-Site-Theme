<?php
/**
 * Header Related Functions
 **/

/**
 * Gets the header image for pages.
 **/
function get_header_images( $obj ) {
	$retval = array(
		'header_image'    => '',
		'header_image_xs' => ''
	);

	// Set post type, term fallback images
	if ( $obj instanceof WP_Post && $obj->post_type === 'degree' ) {
		$college = wp_get_post_terms( $obj->ID, 'colleges' );

		if ( is_array( $college ) ) {
			$college = $college[0];
		}

		if ( $college ) {
			$retval['header_image'] = get_field( 'page_header_image', 'colleges_' . $college->term_id );
			$retval['header_image_xs'] = get_field( 'page_header_image_xs', 'colleges_' . $college->term_id );
		}
	}

	if ( $obj instanceof WP_Post && $obj->post_type === 'location' ) {
		$retval['header_image'] = get_theme_mod_or_default( 'fallback_location_header' );
		$retval['header_image_xs'] = get_theme_mod_or_default( 'fallback_location_header_xs' );
	}

	if ( $obj instanceof WP_Post && $obj->post_type === 'person' ) {
		$retval['header_image'] = get_theme_mod_or_default( 'fallback_person_header' );
		$retval['header_image_xs'] = get_theme_mod_or_default( 'fallback_person_header_xs' );
	}

	// Set object-specific header images, if available
	if ( $obj_header_image = get_field( 'page_header_image', $obj ) ) {
		$retval['header_image'] = $obj_header_image;
	}

	if ( $obj_header_image_xs = get_field( 'page_header_image_xs', $obj ) ) {
		$retval['header_image_xs'] = $obj_header_image_xs;
	}

	// Only return back an image set if the larger `header_image` is set:
	if ( $retval['header_image'] ) {
		return $retval;
	}
	return false;
}


/**
 * Gets the header video sources for pages.
 **/
function get_header_videos( $obj ) {
	$retval = array(
		'webm' => get_field( 'page_header_webm', $obj ),
		'mp4'  => get_field( 'page_header_mp4', $obj )
	);

	$retval = array_filter( $retval );

	// MP4 must be available to display video successfully cross-browser
	if ( isset( $retval['mp4'] ) ) {
		return $retval;
	}

	return false;
}


/**
 * Returns title text for use in the page header.
 **/
 function get_header_title( $obj ) {
	if ( is_404() ) return '';

	$title = '';

	if ( is_tax() || is_category() || is_tag() ) {
		$title = $obj->name;
	}
	else if ( $obj instanceof WP_Post ) {
		$title = $obj->post_title;
	}

	// Apply custom header title override, if available
	if ( $custom_header_title = get_field( 'page_header_title', $obj ) ) {
		$title = do_shortcode( $custom_header_title );
	}

	return wptexturize( $title );
}


/**
 * Returns subtitle text for use in the page header.
 **/
function get_header_subtitle( $obj ) {
	return wptexturize( do_shortcode( get_field( 'page_header_subtitle', $obj ) ) );
}


/**
 * Returns whether the page title or subtitle was designated as the page's h1.
 * Defaults to 'title' if the option isn't set.
 * Will force return a different value if the user screwed up (e.g. specified
 * "subtitle" but didn't provide a subtitle value).
 **/
function get_header_h1_option( $obj ) {
	$subtitle = get_field( 'page_header_subtitle', $obj ) ?: '';
	$h1       = get_field( 'page_header_h1', $obj ) ?: 'title';

	if ( $h1 === 'subtitle' && trim( $subtitle ) === '' ) {
		$h1 = 'title';
	}

	return $h1;
}


/**
 * Returns the class name to apply to a header with a
 * background image/video set to determine its height.
 *
 * @since 3.10.0
 * @author Jo Dickson
 * @param mixed $obj A queried object (e.g. WP_Post, WP_Term), or null
 * @return string
 */
function get_header_media_height( $obj ) {
	$header_height = get_field( 'page_header_height', $obj ) ?: 'header-media-default';

	// Post, term-specific overrides:
	if ( $obj instanceof WP_Post && $obj->post_type === 'person' ) {
		$header_height = 'header-media-person';
	}

	return $header_height;
}


/**
 * Returns the type of header to use for the given object.
 * The value returned will represent an equivalent template part's name.
 *
 * @author Jo Dickson
 * @since 3.10.0
 * @param mixed $obj A queried object (e.g. WP_Post, WP_Term), or null
 * @param array $videos Array of video files set to use in the header background for the given $obj
 * @param array $images Array of image files set to use in the header background for the given $obj
 * @return string The header type name
 */
function get_header_type( $obj, $videos=null, $images=null ) {
	$header_type = '';

	$videos = $videos ?? get_header_videos( $obj );
	$images = $images ?? get_header_images( $obj );

	if ( $videos || $images ) {
		$header_type = 'media';
	}

	return $header_type;
}


/**
 * Returns the type of header content to use for the given object.
 * The value returned will represent an equivalent template part's name.
 *
 * @author Jo Dickson
 * @since 3.10.0
 * @param mixed $obj A queried object (e.g. WP_Post, WP_Term), or null
 * @return string The header type name
 */
function get_header_content_type( $obj ) {
	$content_type = get_field( 'page_header_content_type', $obj ) ?: '';
	$header_type  = get_query_var( 'header_type', null );
	// we shouldn't have to do this, but, just in case:
	if ( $header_type === null ) {
		$header_type = get_header_type( $obj );
	}

	switch ( $header_type ) {
		// If no header background is set, force the fallback
		// header contents to be used:
		case '':
			if ( $content_type === 'title_subtitle' ) {
				$content_type = '';
			}
			break;
		// If a header background is set, ensure stylized title/subtitle
		// are always used by default:
		case 'media':
			if ( ! $content_type ) {
				$content_type = 'title_subtitle';
			}
			break;
		default:
			break;
	}

	// Post, term-specific overrides:
	if ( $obj instanceof WP_Post && $obj->post_type === 'location' ) {
		$content_type = 'location';
	}
	if ( $obj instanceof WP_Post && $obj->post_type === 'degree' ) {
		$content_type = 'degree';
	}
	if ( $obj instanceof WP_Post && $obj->post_type === 'person' ) {
		$content_type = 'person';
	}

	return $content_type;
}


/**
 * Displays a header for the current queried object.
 *
 * @return void
 */
function get_header_markup() {
	$obj    = get_queried_object();
	$videos = get_header_videos( $obj );
	$images = get_header_images( $obj );

	// Determine the header, content types to use
	$header_type = get_header_type( $obj, $videos, $images );
	$header_content_type = get_header_content_type( $obj );
	$header_height = get_header_media_height( $obj );

	// Set some variables to pass along to our template parts
	// NOTE: set_query_var() and get_query_var() usage can be
	// replaced post-WP 5.5:
	// https://developer.wordpress.org/reference/functions/get_template_part/
	set_query_var( 'header_type', $header_type );
	set_query_var( 'header_content_type', $header_content_type );
	set_query_var( 'header_images', $images );
	set_query_var( 'header_videos', $videos );
	if ( $header_type !== '' ) {
		set_query_var( 'header_height', $header_height );
	}

	get_template_part( 'template-parts/layout/header', $header_type );
}
