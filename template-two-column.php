<?php
/**
 * Template Name: Two Column
 **/
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12" id="page_title">
			<h1 class="span8"><?php the_title();?></h1>
			<?=output_weather_data('span4')?>
		</div>
		
		<?=get_page_subheader($post)?>
		
		<div id="sidebar_left" class="span2">
			<?=get_sidebar('left');?>
		</div>
		
		<div class="span10" id="contentcol">
			<article>
				<div class="rightcol_subheader_fix"></div>
				<?php the_content();?>
			</article>
		</div>
	</div>
<?php get_footer();?>