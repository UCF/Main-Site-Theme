<?php get_header(); the_post(); ?>
<?php
	$raw_postmeta        = get_post_meta( $post->ID );
	$post_meta           = format_raw_postmeta( $raw_postmeta );
	$colleges            = wp_get_post_terms( $post->ID, 'colleges' );
	$college             = is_array( $colleges ) ? $colleges[0] : null;
	$breadcrumbs         = get_degree_breadcrumb_markup( $post->ID );

    if( get_field( 'modern_layout_toggle' ) ) {
        echo get_degree_content_modern_layout( $post );
    } else {
        echo get_degree_content_classic_layout( $post );
    }
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
