<?php get_header(); the_post(); ?>

<article class="<?php echo $post->post_status; ?> post-list-item">
	<div class="meta">
		<span class="date"><?php the_time( 'F j, Y' ); ?></span>
		<span class="author">by <?php the_author_posts_link(); ?></span>
	</div>
	<div class="summary">
		<?php the_excerpt(); ?>
	</div>
</article>

<?php get_footer(); ?>
