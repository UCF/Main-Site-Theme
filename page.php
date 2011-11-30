<?php disallow_direct_load('page.php');?>
<?php get_header(); the_post();?>
	
	<div class="span-24 last page-content" id="<?=$post->post_name?>">
		<div class="span-18">
			<article>
				<h1><?php the_title();?></h1>
				<?php the_content();?>
			</article>
		</div>
		
		<div id="sidebar" class="span-6 last">
			<?=get_sidebar();?>
		</div>
		
		<div id="below-the-fold" class="clear">
			<?php get_template_part('includes/below-the-fold'); ?>
		</div>
	</div>

<?php get_footer();?>