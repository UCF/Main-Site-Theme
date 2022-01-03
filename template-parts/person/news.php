<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$person_news = trim( do_shortcode( "[ucf-news-feed title='' search='$post->post_title' layout='modern' limit='4']No results found[/ucf-news-feed]" ) );
	$has_news = $person_news && strpos( $person_news, 'No results found' ) === false;

	if ( $has_news ) :
?>
	<section id="news" aria-labelledby="news-heading">
		<div class="jumbotron jumbotron-fluid bg-faded mb-0">
			<div class="container">
				<h2 class="font-condensed text-uppercase mb-4 mb-sm-5" id="news-heading">In The News</h2>

				<div class="row my-lg-3">
					<div class="col-lg-11 col-xl-10">
						<?php echo $person_news; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
