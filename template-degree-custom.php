<?php
/**
 * Template Name: Degree Custom
 * Template Post Type: degree
 */
?>

<?php get_header(); the_post(); ?>
<?php
	$colleges           = wp_get_post_terms( $post->ID, 'colleges' );
	$college            = is_array( $colleges ) ? $colleges[0] : null;
	$breadcrumbs        = get_degree_breadcrumb_markup( $post->ID );
	$hide_colleges_grid = get_field( 'degree_custom_hide_colleges_grid', $post );
	$enable_rfi_modal   = get_field( 'degree_custom_enable_rfi', $post );
?>

<?php the_content(); ?>

<div class="container mt-4 mb-4 mb-sm-5 pb-md-3">
	<?php echo $breadcrumbs; ?>
</div>

<?php
if ( ! $hide_colleges_grid ) {
	echo get_colleges_grid( $college );
}
?>

<?php
if ( is_graduate_degree( $post ) ) {
	echo get_degree_request_info_modal( $post );
}
?>

<?php get_footer(); ?>
