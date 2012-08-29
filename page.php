<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12" id="page_title">
			<h1 class="span9"><?php the_title();?></h1>
			<?=output_weather_data('span3')?>
		</div>
		
		<?=get_page_subheader($post)?>
		
		<div id="sidebar_left" class="span2">
			<?=get_sidebar('left');?>
		</div>
		
		<div class="span7" id="contentcol">
			<article>
				<?php the_content();?>
				&nbsp;
			</article>
		</div>
		
		<div id="sidebar_right" class="span3 <?php if (get_post_meta($post->ID, 'page_subheader', TRUE) == '') { ?>notoppad<?php } ?>">		
			<?=get_sidebar('right');?>
		</div>
	</div>
<?php get_footer();?>