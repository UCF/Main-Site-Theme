<?php get_header(); the_post(); ?>
<?php $images = get_header_images( $post ); ?>
<header>
	<div class="header-image jumbotron jumbotron-fluid media-background-container">
		<img class="media-background object-fit-cover" src="<?php echo $images['header_image']; ?>" srcset="<?php echo $images['header_image']; ?> 1600w, <?php echo $images['header_image_xs']; ?> 767w" alt="">
		<div class="container">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
</header>
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
