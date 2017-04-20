<?php get_header(); the_post(); ?>
<header>
	<?php echo get_header_image_markup( $post ); ?>
</header>
<article class="<?php echo $post->post_status; ?> post-list-item">
	<?php the_content(); ?>
</article>

<?php get_footer(); ?>
