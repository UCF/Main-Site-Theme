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

	return main_site_format_degree_data( $retval );
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


/**
 * Helper function for getting remote json
 *
 * @author Jim Barnes
 * @since 3.4.0
 * @param string $url The URL to retrieve
 * @param object The serialized JSON obejct
 */
function main_site_get_remote_response_json( $url, $default=null ) {
	$args = array(
		'timeout' => 5
	);

	$retval = $default;
	$response = wp_remote_get( $url, $args );

	if ( is_array( $response ) && wp_remote_retrieve_response_code( $response ) < 400 ) {
		$retval = json_decode( wp_remote_retrieve_body( $response ) );
	}

	return $retval;
}
