<?php disallow_direct_load('single-spotlight.php');?>
<?php get_header(); the_post();?>

	<div class="row page-content" id="<?=$post->post_name?>">
		<div id="page_title" class="col-md-12 col-sm-12">
			<h1 class="col-md-9 col-sm-9">Spotlight: <?php the_title();?></h1>
			<?php esi_include('output_weather_data','col-md-3 col-sm-3'); ?>
		</div>
		<div id="contentcol" class="col-md-12 col-sm-12">
			<article role="main">
				<?=the_content();?>
			</article>
		</div>
	</div>

<?php get_footer();?>
