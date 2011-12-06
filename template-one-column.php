<?php
/**
 * Template Name: One Column
 **/
?>
<?php get_header(); the_post();?>
	
	<div class="span-24 last page-content" id="<?=$post->post_name?>">
		<article>
			<h1><?php the_title();?></h1>
			<?php the_content();?>
		</article>
		
		<?php get_template_part('includes/below-the-fold'); ?>
	</div>

<?php get_footer();?>