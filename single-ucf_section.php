<?php get_header(); the_post(); ?>
<section id="<?php echo $post->post_name; ?>">
	<?php echo the_content(); ?>
</section>
<?php get_footer(); ?>
