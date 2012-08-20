<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<h1><?php the_title();?></h1>
		</div>
		
		<?=get_page_subheader($post)?>
		
		<div id="sidebar_left" class="span2">
			<?=get_sidebar('left');?>
		</div>
		
		<div class="span7" id="contentcol">
			<article>
				<?php the_content();?>
			</article>
		</div>
		
		<div id="sidebar_right" class="span3">		
			<?=get_sidebar('right');?>
		</div>
	</div>
<?php get_footer();?>