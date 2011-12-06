<?php
/**
 * Template Name: Home
 **/
?>
<?php get_header();?>
	<div class="span-24 last page-content" id="<?=$post->post_name?>">
		<div class="span-15 append-1">
			<?php $options = get_option(THEME_OPTIONS_NAME);?>
			<?=wp_get_attachment_image($options['site_image'], 'homepage')?>
			Image Face
		</div>
		
		<div class="span-8 last">
			Description face<br />
			Search Face
		</div>
		
		<?php if(!is_front_page()): the_post(); endif;?>
		<div>
			<?php the_content()?>
		</div>
	</div>

<?php get_footer();?>