<?php @header( 'HTTP/1.1 404 Not found', true, 404 ); ?>

<?php get_header(); the_post();?>
<article role="main" id="page-not-found">
	<div class="container">
		<?php
		$page = get_page_by_title( '404' );
		$content = '';
		if ( $page && $page->post_status === 'publish' ) {
			$content = trim( apply_filters( 'the_content', $page->post_content ) );
		}
		?>
		<?php if ( $content ): ?>
			<?php echo $content; ?>
		<?php else: ?>
			<div class="knightro-bg my-4">
				<div class="row">
					<div class="col-lg-8 col-md-8 col-sm-10">
						<h1 class="text-primary display-3">Page Not Found</h1>
						<p class="lead">Don't give in to despair, your quest continues here...</p>
						<p>Try double-checking the spelling of the address you requested, or search using the field below:</p>
						<form class="search-form mb-3" action="https://search.ucf.edu">
							<div class="input-group">
								<label class="sr-only" for="q-404">Search UCF</label>
								<input id="q-404" class="search-field form-control" name="q" type="text" placeholder="Tell us more about what you're looking for...">
								<input name="client" type="hidden" value="UCF_Main">
								<input name="proxystylesheet" type="hidden" value="UCF_Main">
								<span class="input-group-btn">
									<button class="search-submit btn btn-primary">Search</button>
								</span>
							</div>
						</form>
						<p>
							<small>
								If you feel you've reached this page in error, please let us know: <a href="https://www.ucf.edu/feedback">www.ucf.edu/feedback</a>.
							</small>
						</p>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</article>
<?php get_footer();?>
