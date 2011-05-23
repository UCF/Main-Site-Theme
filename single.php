<?php disallow_direct_load('single.php');?>
<?php get_header(); the_post();?>
	
	<div class="page-content" id="<?=$post->post_name?>">
	</div>

<?php get_footer();?>