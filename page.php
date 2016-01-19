<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="col-md-12" id="page_title">
			<h1 class="col-md-9"><?php the_title();?></h1>
			<?php esi_include('output_weather_data','col-md-3'); ?>
		</div>

		<?=get_page_subheader($post)?>

		<div id="sidebar_left" class="col-md-2" role="navigation">
			<?=get_sidebar('left');?>
		</div>

		<div class="col-md-7" id="contentcol">
			<article role="main">
				<?php the_content();?>
				&nbsp;
			</article>
		</div>

		<div id="sidebar_right" class="col-md-3 <?php if (get_post_meta($post->ID, 'page_subheader', TRUE) == '') { ?>notoppad<?php } ?>" role="complementary">
			<?=get_sidebar('right');?>
		</div>
	</div>
<?php get_footer();?>
