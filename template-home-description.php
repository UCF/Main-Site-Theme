<?php get_header();?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $page    = get_page_by_title('Home');?>
	<div class="span-24 last page-content" id="home" data-template="home-description">
		<div class="site-image span-16">
			<?php $image = wp_get_attachment_image($options['site_image'], 'homepage')?>
			<?php if($image):?>
				<?=$image?>
			<?php else:?>
				<img height="400px" width="620px" src="<?=THEME_IMG_URL?>/default-site-image-540.jpg">
			<?php endif;?>
		</div>
		
		<div class="right-column span-8 last">
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
		
		
		<div class="bottom span-24 last">
			<?php $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', $page->post_content));?>
			<?php if($content):?>
			<?=$content?>
			<?php elseif($page == null):?>
			<p>To edit this content, <a href="<?=get_admin_url()?>post-new.php?post_type=page">create a new page</a> titled "Home" and add your content. The home page image can be set by selecting an uploaded file on the <a href="<?=get_admin_url()?>admin.php?page=theme-options#site">theme options page</a> in the admin.</p>
			<?php endif;?>
		</div>
		
		<?php get_template_part('includes/below-the-fold'); ?>
	</div>

<?php get_footer();?>