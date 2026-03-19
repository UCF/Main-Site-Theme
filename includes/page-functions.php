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
	if ( $column_name !== 'template_name' ) return;

	$template_name_slug_map = wp_get_theme()->get_page_templates();
	$template_slug = get_page_template_slug( $post_id );
	$template_name = array_key_exists( $template_slug, $template_name_slug_map ) ? $template_name_slug_map[ $template_slug ] : 'Default';

	// Use a non-empty sentinel for the default template so filtering can distinguish it from "no filter".
 	$template_query_slug = $template_slug === '' ? 'default' : $template_slug;

	$current_url = add_query_arg(
		array(
			'post_type' => 'page',
		),
		admin_url( 'edit.php' )
	);

	$url = add_query_arg(
		'page_template',
		$template_query_slug,
		$current_url
	);

	ob_start();
?>
	<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $template_name ); ?></a>
<?php
	echo ob_get_clean();
}

add_action( 'manage_page_posts_custom_column', 'main_site_page_template_column_data', 10, 2 );

/**
 * Adds the template_name column to the sortables
 * @author Jim Barnes
 * @since 3.34.2
 * @param array $columns The array of sortable columns
 *
 * @return array
 */
function main_site_register_sortable_columns( $columns ) {
    // 'column_slug' is the ID of your column; 'meta_key' is what we'll check in the query
    $columns['template_name'] = 'template_name';
    return $columns;
}

add_filter( 'manage_edit-page_sortable_columns', 'main_site_register_sortable_columns', 10, 1 );


/**
 * Creates a dropdown of template names
 * and adds it to the page_template screen
 * @author Jim Barnes
 * @since 3.34.2
 *
 * @return void
 */
function main_site_add_template_filter() {
	$screen = get_current_screen();

    if ( $screen->post_type === 'page' ) {
        $selected = $_GET['page_template'] ?? '';
		$page_templates = wp_get_theme()->get_page_templates();

		ob_start();
?>
	<select name="page_template">
		<option value="">All Templates</option>
		<?php foreach( $page_templates as $slug => $name ) : ?>
		<option
			value="<?php echo $slug; ?>"<?php echo $selected === $slug ? ' selected' : ''; ?>>
				<?php echo $name; ?>
		</option>
		<?php endforeach; ?>
	</select>
<?php
        echo ob_get_clean();
    }
}

add_action( 'restrict_manage_posts', 'main_site_add_template_filter', 10, 0 );


/**
 * Sorts the results based on the _wp_page_template
 * @author Jim Barnes
 * @since 3.34.2
 * @param WP_Query $query The incoming query object
 *
 * @return void
 */
function main_site_template_name_order_by( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( 'template_name' === $query->get( 'orderby' ) ) {
        $query->set( 'meta_key', '_wp_page_template' );
        $query->set( 'orderby', 'meta_value' ); // Use 'meta_value' for text
    }

	if ( ! empty( $_GET['page_template'] ) ) {

		$query->set( 'meta_query', array(
			array(
				'key'     => '_wp_page_template',
				'value'   => $_GET['page_template'],
				'compare' => '='
			)
		) );
	}
}

add_action( 'pre_get_posts', 'main_site_template_name_order_by', 10, 1 );
