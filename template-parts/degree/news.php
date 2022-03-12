<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	$degree_news_tag  = trim( get_field( 'degree_news_tag', $post ) ?? '' );
	$news_tag_archive = $degree_news_tag ? 'https://www.ucf.edu/news/tag/' . $degree_news_tag . '/' : 'https://www.ucf.edu/news/';
	$degree_spotlight = get_field( 'degree_spotlight', $post );
	$degree_news_title = get_field( 'degree_news_title', $post );

	if ( empty( $degree_news_title ) ) {
		$degree_news_title = get_header_title( $post ) . ' News';
	}

	if ( $degree_news_tag ) :
?>
	<section id="news" aria-labelledby="in-the-news">
		<div class="jumbotron jumbotron-fluid bg-secondary mb-0">
			<div class="container">
				<div class="row justify-content-between align-items-end">
					<div class="col-auto">
						<h2 class="h3 mb-0" id="in-the-news"><?php echo $degree_news_title; ?></h2>
					</div>
					<div class="col-auto">
						<p class="mb-0">
							<a class="h6 text-uppercase mb-0 text-default-aw text-decoration-none" href="<?php echo $news_tag_archive; ?>">
								Check out more stories
								<span class="fa fa-external-link text-primary" aria-hidden="true"></span>
							</a>
						</p>
					</div>
				</div>

				<hr class="mt-2" role="presentation">

				<div class="row my-lg-3">

					<div class="col-lg">
						<?php echo do_shortcode( '[ucf-news-feed title="" layout="modern" limit="4" topics="' . $degree_news_tag . '"]No articles found.[/ucf-news-feed]' ); ?>
					</div>

					<?php if( $degree_spotlight ) : ?>
						<div class="col-sm-8 col-lg-5 col-xl-4 pl-lg-5 pl-xl-4 mt-4 mt-lg-0">
							<?php echo do_shortcode( '[ucf-spotlight slug="' . $degree_spotlight->post_name . '"]' ); ?>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
