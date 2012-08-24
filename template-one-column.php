<?php
/**
 * Template Name: One Column
 **/
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12" id="page_title">
			<h1 class="span8"><?php the_title();?></h1>
			<?=output_weather_data('span4')?>
		</div>
		
		<?=get_page_subheader($post)?>
		
		<div class="span12" id="contentcol">
			<article>
				<?php if (get_post_meta($post->ID, 'page_subheader', TRUE) !== '') { ?><div class="rightcol_subheader_fix"></div><?php } ?>
				<?php the_content();?>
			</article>
		</div>
	</div>
<?php get_footer();?>