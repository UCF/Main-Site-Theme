<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$media_coverage = get_field( 'expert_media_coverage', $post->ID );
	$today_stories = get_field( 'expert_today_stories', $post->ID );
	$has_news = $media_coverage || $today_stories;

	if ( $has_news ) :
?>
	<section id="news" aria-labelledby="news-heading">
		<div class="jumbotron jumbotron-fluid bg-faded mb-0">
			<div class="container">
				<h2 class="font-condensed text-uppercase mb-4 mb-sm-5" id="news-heading">In The News</h2>
				<div class="row">
					<?php if ( $media_coverage && count( $media_coverage ) ) : ?>
					<div class="col-12 col-md-6">
					<h3 class="h6">Recent Media Coverage</h3>
					<ul class="list-unstyled">
					<?php foreach( $media_coverage as $coverage ) : ?>
						<li class="list-item mb-4">
							<a href="<?php echo $coverage['story_url']; ?>" target="_blank" rel="nofollow">
								<?php echo $coverage['story_title']; ?>
							</a>
						</li>
					<?php endforeach; ?>
					</ul>
					</div>
					<?php endif; ?>
					<?php if ( $today_stories && count( $today_stories ) > 0 ) : ?>
					<div class="col-12 col-md-6">
					<h3 class="h6">UCF News</h3>
					<ul class="list-unstyled">
					<?php foreach( $today_stories as $story ) : ?>
						<li class="list-item mb-4">
							<a href="<?php echo $story['story_url']; ?>" target="_blank" rel="nofollow">
								<?php echo $story['story_title']; ?>
							</a>
						</li>
					<?php endforeach; ?>
					</ul>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php
	endif;
endif;
