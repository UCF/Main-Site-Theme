<?php
/**
 * Template Name: One Column
 **/
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<h1><?php the_title();?></h1>
		</div>
		
		<?=get_page_subheader($post)?>
		
		<div class="span12" id="contentcol">
			<article>
				<div class="rightcol_subheader_fix"></div>
				<?php the_content();?>
			</article>
		</div>
	</div>
<?php get_footer();?>