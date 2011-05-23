<?php @header("HTTP/1.1 404 Not found", true, 404);?>
<?php disallow_direct_load('page.php');?>
<?php get_header(); the_post();?>
	
	<div class="page-content" id="page-not-found">
		<?php 
			$page = get_page_by_title('404');
			if($page){
				$content = $page->post_content;
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]>', $content);
				echo $content;
			}
		?>
		<form id="error404-searchform" method="get" action="<?php bloginfo('url') ?>/">
			<div>
				<input id="error404-s" name="s" type="text" value="<?php echo esc_html(stripslashes(get_query_var('s'))) ?>" size="40" />
				<input id="error404-searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find', 'thematic') ?>" />
			</div>
		</form>
	</div>

<?php get_footer();?>