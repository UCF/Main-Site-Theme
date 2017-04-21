<?php get_header(); the_post(); ?>
<header>
	<?php
		wp_nav_menu( array(
			'theme_location'  => 'header-menu',
			'depth'           => 1,
			'container'       => 'div',
			'container_class' => 'collapse navbar-collapse',
			'container_id'    => 'header-menu',
			'menu_class'      => 'nav navbar-nav justify-content-center',
			'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
			'walker'          => new WP_Bootstrap_Navwalker()
		) );
	?>
	<?php echo get_header_image_markup( $post ); ?>
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
