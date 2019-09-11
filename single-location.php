<?php 
get_header();
the_post(); 

$lat_lon = get_field( "ucf_location_lat_lng" );
?>

<div class="container mt-4 mb-4 mb-sm-5 pb-md-3">
	<div class="row">
		<div class="col-lg-8 col-xl-7 pr-lg-5">

			<div class="d-block d-lg-none">
				<?php echo get_location_html(); ?>
			</div>

		<?php if( isset( $lat_lon ) ) : ?>
			<iframe width="100%" height="300" frameborder="0" allowfullscreen="" class="mb-3"
				src="https://www.google.com/maps/embed/v1/view?key=<?php echo htmlentities( get_theme_mod_or_default( 'google_map_key' ) ); ?>&amp;center=<?php echo $lat_lon["ucf_location_lat"] . "," . $lat_lon["ucf_location_lng"]; ?>&amp;maptype=satellite&amp;zoom=18"></iframe>
		<?php endif; ?>

		<?php if( ! empty( the_content() ) ) : ?>
			<p><?php the_content(); ?></p>
		<?php endif; ?>

		</div>
		<div class="col-lg-4 col-xl-5">
			<div class="d-none d-lg-block">
				<?php echo get_location_html(); ?>
			</div>

			<h3 class="h5 heading-underline mt-3 mt-lg-5">Organizations</h3>

			<ul class="list-unstyled">
				<li><a href="#">TODO</a></li>
			</ul>

			<h3 class="h5 heading-underline mt-4 mt-lg-5">Events at <?php echo the_title(); ?></h3>

			<ul class="list-unstyled">
				<li><a href="#">TODO</a></li>
			</ul>
		</div>
	</div>
</div>

<?php get_footer(); ?>