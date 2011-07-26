<?php @header("HTTP/1.1 404 Not found", true, 404);?>
<?php disallow_direct_load('404.php');?>

<?php get_header(); the_post();?>
	<div class="page-content" id="page-not-found">
		<div class="span-18">
			<h1>Page Not Found</h1>
			<?php 
				$page = get_page_by_title('404');
				if($page){
					$content = $page->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]>', $content);
				}
			?>
			<?php if($content):?>
			<?=$content?>
			<?php else:?>
			<p>The page you requested doesn't exist.  Sorry about that.</p>
			<?php endif;?>
		</div>
		
		<div id="sidebar" class="span-6 last">
			<?=get_sidebar();?>
		</div>
		
		<div class="clear"><!-- --></div>
		<?php get_template_part('templates/below-the-fold'); ?>
	</div>

<?php get_footer();?>