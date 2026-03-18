<?php
/**
 * Provides functions that override WP Page settings
 */

/**
 * Adds categories to pages
 * @author Jim Barnes
 * @since 3.34.2
 * @return void
 */
function main_site_add_categories_to_pages() {
	register_taxonomy_for_object_type( 'category', 'page' );
}

add_action( 'init', 'main_site_add_categories_to_pages', 10, 0 );


/**
 * Adds a column with the page template name
 * @author Jim Barnes
 * @since 3.34.2
 * @param array $columns The columns displayed
 *
 * @return array
 */
function main_site_add_page_template_column( $columns ) {
	$columns['template_name'] = 'Page Template';
	return $columns;
}

add_filter( 'manage_page_posts_columns', 'main_site_add_page_template_column', 10, 1 );

/**
 * Sets the template name for the page template name column
 * @author Jim Barnes
 * @since 3.34.2
 * @return string
 */
function main_site_page_template_column_data( $column_name, $post_id ) {
	$template_name_slug_map = wp_get_theme()->get_page_templates();
	$template_slug = get_page_template_slug( $post_id );
	$template_name = array_key_exists( $template_slug, $template_name_slug_map ) ? $template_name_slug_map[$template_slug] : 'Default';
	echo $template_name;
}

add_action( 'manage_page_posts_custom_column', 'main_site_page_template_column_data', 10, 2 );
