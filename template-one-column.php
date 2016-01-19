<?php
/**
 * Template Name: One Column
 **/
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="col-md-12" id="page_title">
			<h1 class="col-md-9"><?php the_title();?></h1>
			<?php esi_include('output_weather_data','col-md-3'); ?>
		</div>

		<?=get_page_subheader($post)?>

		<div class="col-md-12" id="contentcol">
			<article role="main">
				<?php if (get_post_meta($post->ID, 'page_subheader', TRUE) !== '') { ?><div class="rightcol_subheader_fix"></div><?php } ?>
				<?php the_content();?>
			</article>
		</div>
	</div>
<?php get_footer();?>
