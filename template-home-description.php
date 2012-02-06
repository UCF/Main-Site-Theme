<?php get_header();?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $page    = get_page_by_title('Home');?>
	<div class="span-12 page-content" id="home" data-template="home-description">
		<div class="site-image span8">
			<?php $image = wp_get_attachment_image($options['site_image'], 'homepage')?>
			<?php if($image):?>
				<?=$image?>
			<?php else:?>
				<img height="400px" width="620px" src="<?=THEME_IMG_URL?>/default-site-image-540.jpg">
			<?php endif;?>
		</div>
		
		<div class="right-column span4 last">
			<?php $description = $options['site_description'];?>
			<?php if($description):?>
			<div class="description">
				<p><?=$description?></p>
			</div>
			<?php endif;?>
			
			<div class="search">
				<?php get_search_form();?>
			</div>
		</div>
		
		
		<div class="bottom span12 last">
			<?php $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', $page->post_content));?>
			<?php if($content):?>
			<?=$content?>
			<?php endif;?>
		</div>
		
		<?php get_template_part('includes/below-the-fold'); ?>
	</div>

<?php get_footer();?>