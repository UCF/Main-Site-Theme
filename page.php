<?php get_header(); the_post(); ?>
<article class="<?php echo $post->post_status; ?> post-list-item">
	<?php the_content(); ?>
</article>

<?php get_footer(); ?>
