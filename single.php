<?php disallow_direct_load('single.php');?>
<?php get_header(); the_post();?>
	
	<div class="row page-content" id="<?=$post->post_name?>">
		<div id="page_title" class="span12">
			<h1 class="span9"><?php the_title();?></h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>
		<div id="contentcol" class="span12">
			<article role="main">
				<?=the_content();?>
			</article>
		</div>
	</div>

<?php get_footer();?>