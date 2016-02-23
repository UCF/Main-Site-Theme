<?php
/**
 * Template Name: Two Column, Right Sidebar
 **/
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="col-md-12 col-sm-12">
			<div id="page-title">
				<div class="row">
					<div class="col-md-9 col-sm-9">
						<h1><?php the_title(); ?></h1>
					</div>
					<?php esi_include( 'output_weather_data', 'col-md-3 col-sm-3' ); ?>
				</div>
			</div>
		</div>

		<?=get_page_subheader($post)?>

		<div class="col-md-9 col-sm-9" id="contentcol">
			<article role="main">
				<?php the_content();?>
			</article>
		</div>

		<div id="sidebar_right" class="col-md-3 col-sm-3 <?php if (get_post_meta($post->ID, 'page_subheader', TRUE) == '') { ?>notoppad<?php } ?>" role="navigation">
			<?=get_sidebar('right');?>
		</div>
	</div>
<?php get_footer();?>
