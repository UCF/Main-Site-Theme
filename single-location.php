<?php
get_header();
the_post();

$lat_lng_string = get_location_latlng_str( $post );
$events = ( isset( $post->meta['events_markup'] ) && ! empty( $post->meta['events_markup'] ) ) ? $post->meta['events_markup'] : null;

$featured_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
$location_fallback_image = get_theme_mod_or_default( 'location_fallback_image' );
$location_image = '';

$location_ankle_content = get_theme_mod_or_default( 'location_ankle_content' );

if ( $featured_image ) {
	$location_image = $featured_image;
}
else if ( ! empty( $location_fallback_image ) ) {
	$location_image = $location_fallback_image;
}
?>

<div class="container my-4 my-lg-5">
	<div class="row">
		<div class="col-lg-7">
			<div class="row mb-3">
				<?php if ( $location_image ) : ?>
				<div class="col-md-6">
					<img src="<?php echo $location_image; ?>" alt="" class="img-fluid mb-3">
				</div>
				<?php endif; ?>
				<div class="col-md-6">
					<?php echo get_location_html(); ?>
				</div>
			</div>

			<?php if( ! empty( the_content() ) ) : ?>
				<?php the_content(); ?>
			<?php endif; ?>

			<?php if( ! empty ( $lat_lng_string ) ) : ?>
				<iframe class="mt-3" width="100%" height="300" frameborder="0" allowfullscreen="" title="Map of UCF highlighting <?php echo esc_attr( $post->post_title ); ?>"
					src="https://www.google.com/maps/embed/v1/view?key=<?php echo htmlentities( get_theme_mod_or_default( 'google_map_key' ) ); ?>&amp;center=<?php echo $lat_lng_string; ?>&amp;maptype=satellite&amp;zoom=18"></iframe>

				<p class="text-right">
					<a href="https://map.ucf.edu/?show=<?php echo $post->ucf_location_id; ?>">View UCF Campus Map</a>
				</p>
			<?php endif; ?>

		</div>
		<div class="col-lg-5 col-xl-4 offset-xl-1">
			<div class="row">

				<?php if( $events ) : ?>
					<div class="col-md-7 col-lg-12">
						<h2 class="h5 heading-underline mt-4 mt-md-0">Events</h2>
						<?php echo $events; ?>
					</div>
				<?php endif; ?>

				<div class="col-md-5 col-lg-12">
					<?php echo get_location_spotlight( $post ); ?>
					<?php echo get_location_organizations( $post ); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
if ( $location_ankle_content ) {
	echo apply_filters( 'the_content', $location_ankle_content );
}
?>

<?php get_footer(); ?>
