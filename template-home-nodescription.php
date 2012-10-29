<?php get_header();?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $page    = get_page_by_title('Home');?>
	<div class="row page-content nodescription" id="home" data-template="home-nodescription">
		
		<?php $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', $page->post_content));?>
		<?php if($content):?>
		<?=$content?>
		<?php elseif($page == null):?>
		<p>To edit this content, <a href="<?=get_admin_url()?>post-new.php?post_type=page">create a new page</a> titled "Home" and add your content. The home page image can be set by selecting an uploaded file on the <a href="<?=get_admin_url()?>admin.php?page=theme-options#site">theme options page</a> in the admin.</p>
		<?php endif;?>
	
		
	</div>

<?php get_footer();?>