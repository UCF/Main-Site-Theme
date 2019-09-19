<?php 
get_header();
the_post();

$address = ( isset( $post->ucf_location_address ) ) ? '<h2 class="h6 font-weight-normal">' . $post->ucf_location_address . '</h2>' : "";
$lat_lng = $post->meta['ucf_location_lat_lng'];
$lat_lng_string = ( $lat_lng ) ? $lat_lng["ucf_location_lat"] . "," . $lat_lng["ucf_location_lng"] : "";
$events = ( isset( $post->meta['events_markup'] ) && ! empty( $post->meta['events_markup'] ) ) ? $post->meta['events_markup'] : null;
$featured_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$location_fallback_image = "";

if( ! empty( get_theme_mod_or_default( 'location_fallback_image' ) ) ) {
	$location_fallback_image = '<div class="col-md-6"><img src="' . get_theme_mod_or_default( 'location_fallback_image' ) . '" alt="" class="img-fluid"></div>';
}
?>

<div class="container mt-5 pt-4 mb-4 mb-sm-5 pb-md-3">
	<div class="row">
		<div class="col-lg-7">
			<div class="row mb-3">
					<?php if( $featured_image ) : ?>
						<div class="col-md-6">
							<img src="<?php echo $featured_image ?>" alt="" class="img-fluid mb-3">
						</div>
					<?php else : ?>
						<?php echo $location_fallback_image; ?>
					<?php endif; ?>
				<div class="col-md-6">
					<?php echo get_location_html(); ?>
				</div>
			</div>

			<?php if( ! empty( the_content() ) ) : ?>
				<p><?php the_content(); ?></p>
			<?php endif; ?>

			<?php if( ! empty ( $lat_lng_string ) ) : ?>
				<iframe class="mt-3" width="100%" height="300" frameborder="0" allowfullscreen=""
					src="https://www.google.com/maps/embed/v1/view?key=<?php echo htmlentities( get_theme_mod_or_default( 'google_map_key' ) ); ?>&amp;center=<?php echo $lat_lng_string; ?>&amp;maptype=satellite&amp;zoom=18"></iframe>
				
				<a href="https://map.ucf.edu/?show=<?php echo $post->ucf_location_id; ?>" class="text-right text-uppercase d-block mb-3 pr-2">View on Map</a>
			<?php endif; ?>		

		</div>
		<div class="col-lg-5 col-xl-4 offset-xl-1">
			<div class="row">

				<?php if( $events ) : ?>
					<div class="col-sm-12 col-md-7 col-lg-12">
						<h3 class="h5 heading-underline mt-4 mt-md-0">Events</h3>
						<?php echo $events; ?>
					</div>
				<?php endif; ?>

				<div class="col-sm-12 col-md-5 col-lg-12">
					<?php echo get_location_organizations( $post ); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>