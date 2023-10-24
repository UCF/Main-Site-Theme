<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'person' ) :
	$pegasus_feature_url   = get_field( 'expert_pegasus_feature_url', $post->ID );
	$pegasus_feature_title = get_field( 'expert_pegasus_feature_title', $post->ID );
	$pegasus_feature_image = get_field( 'expert_pegasus_feature_image', $post->ID );
	$pegasus = $pegasus_feature_url && $pegasus_feature_title && $pegasus_feature_url;

	$podcast_url   = get_field( 'expert_podcast_url', $post->ID );
	$podcast_title = get_field( 'expert_podcast_title', $post->ID );
	$podcast_image = get_field( 'expert_podcast_image', $post->ID );
	$podcast = $podcast_url && $podcast_title && $podcast_image;

	$videos = get_field( 'expert_videos', $post->ID );

	$has_marketing = $pegasus || $podcast || $videos;

	if ( $has_marketing ) :
?>
	<section id="marketing" aria-labelledby="marketing-heading">
		<div class="jumbotron jumbotron-fluid bg-inverse mb-0">
			<div class="container">
				<h2 class="font-condensed text-uppercase mb-4 mb-sm-5" id="marketing-heading">UCF Media</h2>
				<div class="row justify-content-between">
				<?php if ( $pegasus ) : ?>
					<div class="col-10 col-md-4">
						<h3 class="text-inverse text-uppercase h6">Pegasus Magazine Feature</h3>
						<div class="card">
							<img src="<?php echo $pegasus_feature_image; ?>" class="card-img" alt="Feature image" />
							<div class="card-block">
								<h4 class="card-title h5 text-secondary"><?php echo $pegasus_feature_title; ?></h4>
								<a href="<?php echo $pegasus_feature_url; ?>" class="d-block btn btn-primary" target="_blank">Read the Story</a> 
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $podcast ) : ?>
					<div class="col-10 col-md-4">
						<h3 class="text-inverse text-uppercase h6">Podcast Feature</h3>
						<div class="card">
							<img src="<?php echo $podcast_image; ?>" class="card-img" alt="Feature image" />
							<div class="card-block">
								<h4 class="card-title h5 text-secondary"><?php echo $podcast_title; ?></h4>
								<a href="<?php echo $podcast_url; ?>" class="d-block btn btn-primary" target="_blank">Read the Story</a> 
							</div>
						</div>
					</div>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="container mb-4">
			<h3 class="font-condensed text-uppercase my-4 mb-sm-5">Videos</h3>
			<?php foreach( $videos as $video ) : ?>
				<div class="embed-responsive embed-responsive-16by9">
				<?php echo do_shortcode( $video['video'] ); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
<?php
	endif;
endif;
