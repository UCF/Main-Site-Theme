<?php
	$path = $Path=$_SERVER['REQUEST_URI'];

	if(substr($path,0,14) == '/degree-search') {
		wp_redirect( '/degree-search/', 301 );
		exit;
	}
?>

<?php @header("HTTP/1.1 404 Not found", true, 404);?>
<?php disallow_direct_load('404.php');?>

<?php get_header(); the_post();?>
	<div class="row page-content" id="page-not-found">
		<div id="page_title" class="span12">
			<h1 class="span9">Page Not Found</h1>
			<?php esi_include('output_weather_data','span3'); ?>
		</div>
		<div id="contentcol" class="span12">
			<article role="main">
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
					<div class="row">
						<div class="span12">
							<p>&nbsp;</p>
							<p class="lead">The page you were looking for appears to have been moved, deleted or does not exist. Try using the navigation or search above or browse to the <a href="/">home page</a>.</p>
						</div>
					</div>
				</div>

				<?php endif;?>
			</article>
		</div>
	</div>
<?php get_footer();?>
