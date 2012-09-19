<?php @header("HTTP/1.1 404 Not found", true, 404);?>
<?php disallow_direct_load('404.php');?>

<?php get_header(); the_post();?>
	<div class="row page-content" id="page-not-found">
		<div id="page_title" class="span12">
			<h1 class="span9">Page Not Found</h1>
			<?php esi_include('output_weather_data(\'span3\');'); ?>
		</div>
		<div id="contentcol" class="span12">
			<article>
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
			</article>
		</div>
	</div>
<?php get_footer();?>