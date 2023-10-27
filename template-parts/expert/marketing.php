<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$pegasus_feature_url   = get_field( 'expert_pegasus_feature_url', $post->ID );
	$pegasus_feature_title = get_field( 'expert_pegasus_feature_title', $post->ID );
	$pegasus_feature_image = get_field( 'expert_pegasus_feature_image', $post->ID );
	$pegasus_feature_desc  = get_field( 'expert_pegasus_feature_description', $post->ID );
	$pegasus = $pegasus_feature_url && $pegasus_feature_title && $pegasus_feature_url;

	$podcast_url   = get_field( 'expert_podcast_url', $post->ID );
	$podcast_title = get_field( 'expert_podcast_title', $post->ID );
	$podcast_image = get_field( 'expert_podcast_image', $post->ID );
	$podcast_desc  = get_field( 'expert_podcast_description', $post->ID );
	$podcast = $podcast_url && $podcast_title && $podcast_image;

	$videos = get_field( 'expert_videos', $post->ID );

	$has_marketing = $pegasus || $podcast || $videos;

	if ( $has_marketing ) :
?>
	<section id="marketing" aria-labelledby="marketing-heading">
		<div class="jumbotron jumbotron-fluid mb-0">
			<div class="container">
				<h2 class="font-condensed text-uppercase mb-4 mb-sm-5" id="marketing-heading">UCF Media Resources</h2>
				<div class="row">
				<?php if ( $pegasus ) : ?>
				<div class="col-md-6">
					<div class="card h-100 rounded">
						<div class="card-block pb-4">
							<div class="row">
								<div class="col-md-6" role="img" aria-label="<?php echo $pegasus_feature_title; ?>">
									<img src="<?php echo $pegasus_feature_image; ?>" class="card-img" alt="Feature image" />
								</div>
								<div class="col-md-6">
									<h3 class="h5 mb-1 pt-3 pt-md-3 heading-underline"><?php echo $pegasus_feature_title; ?></h4>
									<p class="font-weight-light line-height-4"><?php echo $pegasus_feature_desc; ?></p>
									<a href="<?php echo $pegasus_feature_url; ?>" class="stretched-link text-secondary" target="_blank">
										Learn More
										<span class="arrow-br-icon text-uppercase small" aria-hidden="true"></span>
									</a> 
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<?php if ( $podcast ) : ?>
				<div class="col-md-6">
					<div class="card h-100 rounded">
						<div class="card-block pb-4">
							<div class="row">
								<div class="col-md-6" role="img" aria-label="<?php echo $podcast_title; ?>">
									<img src="<?php echo $podcast_image; ?>" class="card-img" alt="Feature image" />
								</div>
								<div class="col-md-6">
									<h3 class="h5 mb-1 pt-3 pt-md-3 heading-underline"><?php echo $podcast_title; ?></h4>
									<p class="font-weight-light line-height-4"><?php echo $podcast_desc; ?></p>
									<a href="<?php echo $podcast_url; ?>" class="stretched-link text-secondary" target="_blank">
										Learn More
										<span class="arrow-br-icon text-uppercase small" aria-hidden="true"></span>
									</a> 
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<?php if ( $videos ): ?>
		<div class="jumbotron jumbotron-fluid bg-secondary mb-0">
			<div class="container">
				<h3 class="font-condensed text-uppercase mb-4 mb-sm-5">Related Videos</h3>
				<div class="row">
				<?php foreach( $videos as $video ) : ?>
				<div class="col-md-6 col-lg-4">
					<div class="embed-responsive embed-responsive-16by9">
					<?php echo do_shortcode( $video['video'] ); ?>
					</div>
				</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</section>
<?php
	endif;
endif;
