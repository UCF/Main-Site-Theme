<?php
/**
 * Template Name: Custom Degree
 * Template Post Type: degree
 */
?>

<?php get_header(); the_post(); ?>
<?php
	$colleges           = wp_get_post_terms( $post->ID, 'colleges' );
	$college            = is_array( $colleges ) ? $colleges[0] : null;
	$hide_colleges_grid = get_field( 'degree_custom_hide_colleges_grid', $post );
?>

<?php the_content(); ?>

<?php get_template_part( 'template-parts/degree/breadcrumbs' ); ?>

<?php
if ( ! $hide_colleges_grid ) {
	echo get_colleges_grid( $college );
}
?>

<?php get_template_part( 'template-parts/degree/rfi_modal' ); ?>

<?php get_footer(); ?>
