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
 * Helper function for retrieving a remote response
 *
 * @author Jo Dickson
 * @since 3.9.0
 * @param mixed $remote The URL to retrieve, or a response array from wp_remote_get()
 * @param int $timeout Timeout for the request, in seconds
 * @return mixed Array of response data, or null on failure/bad response
 */
function main_site_get_remote_response( $url, $timeout=5 ) {
	$retval = null;
	if ( ! $url || ! is_string( $url ) ) return $retval;

	$args = array(
		'timeout' => $timeout
	);
	$response = wp_remote_get( $url, $args );

	if ( is_array( $response ) && wp_remote_retrieve_response_code( $response ) < 400 ) {
		$retval = $response;
	}

	return $retval;
}


/**
 * Helper function for getting remote json
 *
 * @author Jim Barnes
 * @since 3.4.0
 * @param mixed $remote The URL to retrieve, or a response array from wp_remote_get()
 * @param mixed $default A default value to return if the response is invalid
 * @param int $timeout Timeout for the request, in seconds
 * @return mixed The serialized JSON object, or $default
 */
function main_site_get_remote_response_json( $remote, $default=null, $timeout=5 ) {
	$retval   = $default;
	$response = is_array( $remote ) ? $remote : main_site_get_remote_response( $remote, $timeout );

	if ( $response ) {
		$json = json_decode( wp_remote_retrieve_body( $response ) );
		if ( $json ) {
			$retval = $json;
		}
	}

	return $retval;
}
