<?php
/**
 * Template Name: Video Transcript
 * Template Post Type: page
 */
?>

<?php get_header(); the_post(); ?>

<?php

$full_transcript = get_field( 'video_full_transcript', $post->ID );
$video_sections = get_field( 'video_sections', $post->ID );
$spotlight = get_field( 'video_spotlight', $post->ID );

?>

<div class="video-template-content">
	<div class="container">
		<?php echo the_content(); ?>
		<div class="row">
			<div class="col-md-7">
				<h2>Video Transcripts</h2>
				<div id="video-chapters" role="tablist">
				<?php foreach( $video_sections as $idx => $section ) : ?>
					<?php $section_id = sanitize_title( $section['section_title'] ); ?>
					<div class="card">
						<div class="card-header" id="<?php echo $section_id; ?>-id">
							<h3 class="h5 mb-0">
								<a data-toggle="collapse" href="#<?php echo $section_id; ?>"<?php echo ( $idx === 0 ) ? "aria-expanded=\"true\"" : ""; ?> aria-controls="<?php echo $section_id; ?>">
									<?php echo $section['section_title']; ?>
								</a>
							</h3>
						</div>
						<div class="collapse<?php echo ( $idx === 0 ) ? " show" : ""; ?>" id="<?php echo $section_id; ?>" role="tabpanel" aria-labelledby="#<?php echo $section_id; ?>-id" data-parent="#video-chapters">
							<div class="card-block">
								<p class="text-center h6"><?php echo $section['section_time_stamp']; ?></p>
								<?php echo wpautop( $section['section_summary'] ); ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
			<div class="col-md-5">
				<div class="card card-faded">
					<img class="img-fliod card-top" src="<?php echo $spotlight['spotlight_image']; ?>" alt="" />
					<div class="card-block">
						<h2><?php echo $spotlight['spotlight_title']; ?></h2>
						<?php echo wpautop( $spotlight['spotlight_content'] ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
