<?php get_header();?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $page    = get_page_by_title('Home');?>
	<div class="span-24 last page-content nodescription" id="home" data-template="home-nodescription">
		<div class="content span-10">
			<?php $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', $page->post_content));?>
			<?=$content?>
		</div>
		
		<div class="site-image span-14 last">
			<?=wp_get_attachment_image($options['site_image'], 'homepage-secondary')?>
			<div class="search">
				<?php get_search_form();?>
			</div>
		</div>
		
		<?php get_template_part('includes/below-the-fold'); ?>
	</div>

<?php get_footer();?>