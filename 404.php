<?php @header("HTTP/1.1 404 Not found", true, 404);?>
<?php disallow_direct_load('404.php');?>

<?php get_header(); the_post();?>
	<div class="row page-content" id="page-not-found">
		<div id="contentcol" class="col-md-12 col-sm-12">
			<article role="main">
				<?php
				$page = get_page_by_title( '404' );
				if ( $page ){
					$content = trim( apply_filters( 'the_content', $page->post_content ) );
				}
				?>
				<?php if ( $content ): ?>
					<?php echo $content; ?>
				<?php else: ?>
					<div class="knightro-bg">
						<div class="row">
							<div class="col-md-8 col-sm-8">
								<h1>Page Not Found</h1>
								<p class="lead">Don't give in to despair, your quest continues here...</p>
								<p>Try double-checking the spelling of the address you requested, or search using the field below:</p>
								<form class="search-form" action="https://google.cc.ucf.edu/search">
									<label class="sr-only" for="q">Search UCF</label>
									<input id="q-404" class="search-field" name="q" type="text" placeholder="Tell us more about what you're looking for...">
									<input name="client" type="hidden" value="UCF_Main">
									<input name="proxystylesheet" type="hidden" value="UCF_Main">
									<button class="search-submit">Search</button>
								</form>
								<p>
									<small>
										If you feel you've reached this page in error, please let us know: <a href="http://www.ucf.edu/feedback">www.ucf.edu/feedback</a>.
									</small>
								</p>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</article>
		</div>
	</div>
<?php get_footer();?>
