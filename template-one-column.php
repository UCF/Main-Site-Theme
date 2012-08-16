<?php
/**
 * Template Name: One Column
 **/
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<article>
				<? if(!is_front_page())	{ ?>
						<h1><?php the_title();?></h1>
				<? } ?>
				<?php the_content();?>
			</article>
		</div>
	</div>
<?php get_footer();?>