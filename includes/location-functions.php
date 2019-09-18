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
	$lat_lng = $post->meta['ucf_location_lat_lng'];
	$google_map_link = ( $lat_lng ) ? "https://www.google.com/maps?saddr=&daddr=" . $lat_lng["ucf_location_lat"] . "," . $lat_lng["ucf_location_lng"] : "";

	ob_start();
?>
	<p>
		<?php echo $id; ?>
		<?php echo $abbr; ?>
	</p>

	<?php if( ! empty( $google_map_link ) ) : ?>
		<a href="<?php echo $google_map_link; ?>" target="_blank" rel="noopener" class="btn btn-secondary btn-sm text-uppercase mb-4 mt-2">Get Directions</a>
	<?php endif; ?>

<?php
	return ob_get_clean();
}
?>