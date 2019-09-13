<?php 
get_header();
the_post();

$lat_lng = $post->meta['ucf_location_lat_lng'];
$lat_lng_string = ( $lat_lng ) ? $lat_lng["ucf_location_lat"] . "," . $lat_lng["ucf_location_lng"] : "";
$events = ( isset( $post->meta['events_markup'] ) && ! empty( $post->meta['events_markup'] ) ) ? $post->meta['events_markup'] : null;
?>

<div class="container mt-4 mb-4 mb-sm-5 pb-md-3">
	<div class="row">
		<div class="col-md-8 col-xl-8">

			<div class="d-block d-md-none">
				<?php echo get_location_html(); ?>
			</div>

		<?php if( ! empty ( $lat_lng_string ) ) : ?>
			<iframe width="100%" height="300" frameborder="0" allowfullscreen=""
				src="https://www.google.com/maps/embed/v1/view?key=<?php echo htmlentities( get_theme_mod_or_default( 'google_map_key' ) ); ?>&amp;center=<?php echo $lat_lng_string; ?>&amp;maptype=satellite&amp;zoom=18"></iframe>
		<?php endif; ?>

			<a href="https://map.ucf.edu/?show=<?php echo $post->ucf_location_id; ?>" class="text-right text-uppercase d-block mb-3 pr-2">View on Map</a>

		<?php if( ! empty( the_content() ) ) : ?>
			<p><?php the_content(); ?></p>
		<?php endif; ?>

		</div>
		<div class="col-md-4 col-xl-3 offset-xl-1">
			<div class="d-none d-md-block">
				<?php echo get_location_html(); ?>
			</div>

			<h3 class="h5 heading-underline mt-4">Organizations</h3>

			<ul class="list-unstyled">
				<li><a href="#">TODO</a></li>
			</ul>

		<?php if( $events ) : ?>
			<h3 class="h5 heading-underline mt-4">Events</h3>
			<?php echo $events; ?>
		<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>