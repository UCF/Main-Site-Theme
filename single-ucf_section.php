<?php get_header(); the_post(); ?>
<?php echo do_shortcode( '[ucf-section slug="' . $post->post_name . '"]' ); ?>
<?php get_footer(); ?>
