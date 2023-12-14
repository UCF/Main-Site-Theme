<?php

/**
 * Returns the expert filter url with the
 * appropriate filter attached.
 *
 * @author Jim Barnes
 * @since 3.18.2
 * @param string|null $expertise The expertise to add the the URL
 * @return string
 */
function get_expert_filter_url( $expertise = null ) {
	$page_path = get_theme_mod_or_default( 'expert_search_page_path' );

	if ( ! $page_path ) return "";

	$page = get_page_by_path( $page_path );

	if ( ! $page ) return "";

	$retval = get_permalink( $page );

	if ( $expertise ) {
		$retval .= "?expertise=$expertise";
	}

	return $retval;
}
