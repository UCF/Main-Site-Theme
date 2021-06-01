<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$person_news = do_shortcode( '[ucf-news-feed title="" feed_url="" layout="modern" limit="4"][/ucf-news-feed]' );

	if ( $person_news ) :
		$person_spotlight = null; // TODO
?>
	<section id="news" aria-labelledby="news-heading">
		<div class="jumbotron jumbotron-fluid bg-faded mb-0">
			<div class="container">
				<h2 class="font-condensed text-uppercase mb-4" id="news-heading">In The News</h2>

				<div class="row my-lg-3">
					<div class="col-lg-7">
						<?php echo $person_news; ?>
					</div>

					<?php if ( $person_spotlight ) : ?>
						<div class="col-sm-8 col-lg-5 col-xl-4 pl-lg-5 pl-xl-4 mt-4 mt-lg-0">
							<?php echo do_shortcode( '[ucf-spotlight slug="' . $person_spotlight->post_name . '"]' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
