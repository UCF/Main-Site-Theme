<?php get_header();?>
<div class="page-content" id="post-list">
	<div class="span-18">
		<?php while(have_posts()): the_post();?>
		<article>
			<h1><a href="<?php the_permalink();?>"><?php the_title();?></a></h1>
			<div class="meta">
				<span class="date"><?php the_time("F j, Y");?></span>
				<span class="author">by <?php the_author_posts_link();?></span>
			</div>
			<div class="summary">
				<?php the_excerpt();?>
			</div>
		</article>
		<?php endwhile;?>
	</div>
	<div id="sidebar" class="span-6 last">
		<?=get_sidebar();?>
	</div>
	
	<div id="below-the-fold" class="clear">
		<?php get_template_part('templates/below-the-fold'); ?>
	</div>
</div>
<?php get_footer();?>