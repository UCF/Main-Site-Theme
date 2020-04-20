<?php
/**
 * Template Name: Degree Modern
 * Template Post Type: degree
 */
?>

<?php get_header(); the_post(); ?>
<?php
	$raw_postmeta      = get_post_meta( $post->ID );
	$post_meta         = format_raw_postmeta( $raw_postmeta );
	$program_type      = get_degree_program_type( $post );
	$colleges          = wp_get_post_terms( $post->ID, 'colleges' );
	$college           = is_array( $colleges ) ? $colleges[0] : null;
	$colleges_list     = get_colleges_markup( $post->ID );
	$departments_list  = get_departments_markup( $post->ID );
	$breadcrumbs       = get_degree_breadcrumb_markup( $post->ID );
	$hide_catalog_desc = ( isset( $post_meta['degree_disable_catalog_desc'] ) && filter_var( $post_meta['degree_disable_catalog_desc'], FILTER_VALIDATE_BOOLEAN ) === true );

    echo get_degree_content_modern_layout( $post );
?>

<div class="container mt-4 mb-4 mb-sm-5 pb-md-3">
    <?php echo $breadcrumbs; ?>
</div>

<?php
if ( isset( $post_meta['degree_full_width_content_bottom'] ) && ! empty( $post_meta['degree_full_width_content_bottom'] ) ) {
	echo apply_filters( 'the_content', $post_meta['degree_full_width_content_bottom'] );
}
?>

<?php echo get_colleges_grid( $college ); ?>

<?php get_footer(); ?>
