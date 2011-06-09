<?php disallow_direct_load('single.php');?>
<?php get_header(); the_post();?>
	
	<div class="span-24 last page-content" id="<?=$post->post_name?>">
		<div class="span-18">
			<h2><?php the_title();?></h2>
			<?php the_content();?>
		</div>
		<div class="span-6 last">
			<?=get_sidebar();?>
		</div>
	</div>

<?php get_footer();?>