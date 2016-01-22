<?php get_header(); the_post();?>
	<div class="row page-content" id="<?php echo $post->post_name; ?>">
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

		<div class="col-md-7 col-sm-7 col-md-push-2 col-sm-push-2" id="contentcol">
			<article role="main">
				<?php the_content();?>
				&nbsp;
			</article>
		</div>

		<div id="sidebar_left" class="col-md-2 col-sm-2 col-md-pull-7 col-sm-pull-7" role="navigation">
			<?=get_sidebar('left');?>
		</div>

		<div id="sidebar_right" class="col-md-3 col-sm-3 <?php if (get_post_meta($post->ID, 'page_subheader', TRUE) == '') { ?>notoppad<?php } ?>" role="complementary">
			<?=get_sidebar('right');?>
		</div>
	</div>
<?php get_footer();?>
