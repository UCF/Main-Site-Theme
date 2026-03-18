<?php
/**
 * Provides functions that override WP Page settings
 */
function main_site_add_categories_to_pages() {
	register_taxonomy_for_object_type( 'category', 'page' );
}

add_action( 'init', 'main_site_add_categories_to_pages', 10, 0 );
