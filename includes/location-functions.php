<?php
/**
 * Returns markup for the location details.
 *
 * @author RJ Bruneel
 * @since v3.2.8
 * @return string Location details HTML
 */
function get_location_html() {

	$post = get_post();
	$post_name = $post->post_name;
	$abbr = isset( $post->meta['ucf_location_abbr'] ) ? $post->meta['ucf_location_abbr'] : null;

	$id = isset( $post->meta['ucf_location_id'] ) ? $post->meta['ucf_location_id'] : null;
	$id = ( isset( $id ) && $id . '-' . strtolower( $abbr ) !== $post_name ) ? "Location ID: $id <br>" : "";

	$abbr = ( $abbr ) ? "Abbreviation: " .  $abbr : "";
	$address = preg_replace( '/,/', '<br>', $post->ucf_location_address, 1 );
	$lat_lng = $post->meta['ucf_location_lat_lng'];
	$google_map_link = ( $lat_lng ) ? "https://www.google.com/maps?saddr=&daddr=" . $lat_lng["ucf_location_lat"] . "," . $lat_lng["ucf_location_lng"] : "";

	ob_start();
?>
	<p>
		<?php echo $id; ?>
		<?php echo $abbr; ?>
	</p>

<?php if( isset( $address ) ) : ?>
	<p>
	<?php if( ! empty( $google_map_link ) ) : ?>
		<a href="<?php echo $google_map_link; ?>" target="_blank" rel="noopener">
	<?php endif; ?>
			<?php echo $address; ?>
	<?php if( ! empty( $google_map_link ) ) : ?>
		</a>
	<?php endif; ?>
	</p>
<?php endif; ?>

<?php if( ! empty( $google_map_link ) ) : ?>
	<a href="<?php echo $google_map_link; ?>" target="_blank" rel="noopener" class="btn btn-secondary btn-sm text-uppercase mb-4 mt-2">Get Directions</a>
<?php endif; ?>

<?php
	return ob_get_clean();
}

/**
 * Filter for setting the custom header content
 * @author Jim Barnes
 * @since 1.0.0
 * @param string $markup The passed in markup
 * @param object $obj The page object
 * @return string The header markup
 */
function get_header_content_custom_location( $markup, $obj ) {
	if ( isset( $obj->post_type ) && $obj->post_type === 'location' ) {
		$title = $obj->post_title;
		$address = isset( $obj->meta['ucf_location_address'] ) ?
					$obj->meta['ucf_location_address'] :
					null;

		ob_start();
	?>
		<div class="header-content-inner align-self-start pt-4 pt-sm-0 align-self-sm-center">
			<div class="container">
				<div class="d-inline-block bg-primary-t-1">
					<h1 class="header-title"><?php echo $title; ?></h1>
				</div>
				<?php if ( $address ) : ?>
				<div class="clearfix"></div>
				<div class="d-inline-block bg-inverse">
					<address class="d-block header-subtitle location-address"><?php echo $address; ?></address>
				</div>
				<?php endif; ?>
			</div>
		</div>
	<?php
		$retval = ob_get_clean();

		return $retval;
	}
}

add_filter( 'get_header_content_title_subtitle', 'get_header_content_custom_location', 10, 2 );
