<?php
/**
 * General utilities
 **/
function format_raw_postmeta( $postmeta ) {
	$retval = array();

	foreach( $postmeta as $key=>$val ) {
		if ( is_array( $val ) && count( $val ) === 1 ) {
			$retval[$key] = $val[0];
		} else {
			$retval[$key] = $val;
		}
	}

	return $retval;
}


/**
 * Returns a theme mod value from THEME_CUSTOMIZER_DEFAULTS.
 **/
function get_theme_mod_default( $theme_mod ) {
	$defaults = unserialize( THEME_CUSTOMIZER_DEFAULTS );
	if ( $defaults && isset( $defaults[$theme_mod] ) ) {
		return $defaults[$theme_mod];
	}
	return false;
}


/**
 * Returns a theme mod value or the default set in THEME_CUSTOMIZER_DEFAULTS if
 * the theme mod value hasn't been set yet.
 **/
function get_theme_mod_or_default( $theme_mod ) {
	$mod = get_theme_mod( $theme_mod  );
	$default = get_theme_mod_default( $theme_mod );

	// Only apply the default if an explicit theme mod value hasn't been set
	// yet (e.g. immediately after theme activation). Otherwise, assume empty
	// values are intentional.
	if ( $mod === false && $default ) {
		return $default;
	}
	return $mod;
}


/**
 * Given a WP_Term or WP_Post object, returns the relevant object ID property
 * or null.
 **/
function get_object_id( $obj ) {
	$obj_id = null;

	if ( $obj instanceof WP_Post ) {
		$obj_id = $obj->ID;
	}
	else if ( $obj instanceof WP_Term ) {
		$obj_id = $obj->term_id;
	}

	return $obj_id;
}


/**
 * Given a WP_Term or WP_Post object, returns the relevant $post_id argument
 * for ACF field retrieval/modification functions (e.g. get_field()) or null.
 **/
function get_object_field_id( $obj ) {
	$field_id = null;

	if ( $obj instanceof WP_Post ) {
		$field_id = $obj->ID;
	}
	else if ( $obj instanceof WP_Term ) {
		$field_id = $obj->taxonomy . '_' . $obj->term_id;
	}

	return $field_id;
}


/**
 * Utility function that returns an image url by its thumbnail size.
 **/
function get_attachment_src_by_size( $id, $size ) {
	$attachment = wp_get_attachment_image_src( $id, $size, false );
	if ( is_array( $attachment ) ) {
		return $attachment[0];
	}
	return $attachment;
}



if ( ! function_exists( 'is_rest' ) ) {
	/**
	 * Checks if the current request is a WP REST API request.
	 *
	 * @return boolean
	 * @see https://gist.github.com/matzeeable/dfd82239f48c2fedef25141e48c8dc30
	 */
	function is_rest() {
		if (
			( defined( 'REST_REQUEST' ) && REST_REQUEST )
			|| (
				isset( $_GET['rest_route'] )
				&& strpos( trim( $_GET['rest_route'], '\\/' ), rest_get_url_prefix() , 0 ) === 0
			)
		) {
			return true;
		}

		global $wp_rewrite;
		if ( $wp_rewrite === null ) $wp_rewrite = new WP_Rewrite();

		$rest_url = wp_parse_url( trailingslashit( rest_url() ) );
		$current_url = wp_parse_url( add_query_arg( array() ) );
		return strpos( $current_url['path'], $rest_url['path'], 0 ) === 0;
	}
}
