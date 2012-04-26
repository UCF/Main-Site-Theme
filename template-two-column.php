<?php
/**
 * Template Name: Two Column
 **/
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span9">
			<article>
				<? if(!is_front_page())	{ ?>
						<h1><?php the_title();?></h1>
				<? } ?>
				<?php the_content();?>
			</article>
		</div>
		
		<div id="sidebar" class="span3">
			<?=get_sidebar();?>
		</div>
	</div>
	<?
	if(get_post_meta($post->ID, 'page_hide_fold', True) != 'on'): 
		get_template_part('includes/below-the-fold'); 
	endif
	?>
<?php get_footer();?>