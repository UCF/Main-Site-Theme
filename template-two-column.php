<?php
/**
 * Template Name: Two Column
 **/
?>
<?php get_header(); the_post();?>
	
	<div class="span12 page-content" id="<?=$post->post_name?>">
		<div class="span9">
			<article>
				<h1><?php the_title();?></h1>
				<?php the_content();?>
			</article>
		</div>
		
		<div id="sidebar" class="span3 last">
			<?=get_sidebar();?>
		</div>
		
		<?
		if(get_post_meta($post->ID, 'page_hide_fold', True) != 'on'): 
			get_template_part('includes/below-the-fold'); 
		endif
		?>
	</div>

<?php get_footer();?>