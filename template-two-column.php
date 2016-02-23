<?php
/**
 * Template Name: Two Column, Left Sidebar
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

		<div class="col-md-10 col-sm-10 col-md-push-2 col-sm-push-2" id="contentcol">
			<article role="main">
				<?php if (get_post_meta($post->ID, 'page_subheader', TRUE) !== '') { ?><div class="rightcol_subheader_fix"></div><?php } ?>
				<?php the_content();?>
			</article>
		</div>

		<div id="sidebar_left" class="col-md-2 col-sm-2 col-md-pull-10 col-sm-pull-10" role="navigation">
			<?=get_sidebar('left');?>
		</div>
	</div>
<?php get_footer();?>
