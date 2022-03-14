<?php
/**
 * Returns markup for the location details.
 *
 * @author RJ Bruneel
 * @since 3.2.8
 * @return string Location details HTML
 */
function get_location_html() {

	$post = get_post();
	$post_name = $post->post_name;

	$campus = null;
	if ( isset( $post->meta['ucf_location_campus'] ) ) {
		if( isset( $post->meta['ucf_location_campus']->post_title ) ) {
			$campus = $post->meta['ucf_location_campus']->post_title;
		}
	}
	$abbr = isset( $post->meta['ucf_location_abbr'] ) ? $post->meta['ucf_location_abbr'] : null;
	$id = ( isset( $post->meta['ucf_location_id'] ) && $post->meta['ucf_location_id'] !== $post_name  ) ? $post->meta['ucf_location_id'] : null;

	$lat_lng_str = get_location_latlng_str( $post );
	$google_map_link = $lat_lng_str ? 'https://www.google.com/maps?saddr=&daddr=' . $lat_lng_str : null;

	ob_start();
?>
	<?php if( $campus ) : ?>
		<div class="row">
			<div class="col-12 mb-3">
				<strong class="text-uppercase">Campus</strong><br>
				<?php echo $campus ?>
			</div>
		</div>
	<?php endif; ?>
	<?php if( $abbr ) : ?>
		<div class="row">
			<div class="col-5 col-md-6 col-lg-7 col-xl-6 text-uppercase font-weight-bold">
				Abbreviation
			</div>
			<div class="col"><?php echo $abbr ?></div>
		</div>
	<?php endif; ?>
	<?php if( $id ) : ?>
		<div class="row">
			<div class="col-5 col-md-6 col-lg-7 col-xl-6 text-uppercase font-weight-bold">Location ID</div>
			<div class="col"><?php echo $id ?></div>
		</div>
	<?php endif; ?>
	<?php if( ! empty( $google_map_link ) ) : ?>
		<a href="<?php echo $google_map_link; ?>" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm text-uppercase mb-4 mt-3">
			<span class="fa fa-location-arrow" aria-hidden="true"></span>
			Get Directions
		</a>
	<?php endif; ?>

<?php
	return ob_get_clean();
}

/**
 * Returns a formatted phone link.
 *
 * @author RJ Bruneel
 * @since 3.2.8
 * @param object $object org object
 * @param string $index org phone index
 * @return string Location details HTML
 */
function format_phone_link( $object, $index ) {
	return '<a href="tel:+1' . preg_replace( "/[^0-9,.]/", "", $object[$index] ) . '">' . $object[$index] . '</a>';
}

/**
 * Outputs the organization html.
 *
 * @author RJ Bruneel
 * @since 3.2.8
 * @param string $markup The passed in markup
 * @param object $obj The page object
 * @return string The header markup
*/
function get_organization_html( $title, $org, $count ) {

	ob_start();

	if ( isset( $org['org_name'] ) && ! empty( $org['org_name'] ) ) : ?>
		<dt>
			<a href="#collapse<?php echo $count; ?>" class="org-dept-name d-inline-block" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse<?php echo $count; ?>">
				<?php echo $org['org_name']; ?>
			</a>
		</dt>
	<?php endif; ?>

	<div class="collapse pb-2" id="collapse<?php echo $count; ?>">

		<?php if ( isset( $org['org_room'] ) && ! empty( $org['org_room'] ) ) : ?>
			<dd class="mb-0">
				 <?php echo $title ?>, Room <?php echo $org['org_room']; ?>
			</dd>
		<?php endif; ?>

		<?php if ( isset( $org['org_phone'] ) && ! empty( $org['org_phone'] ) ) : ?>
			<dd>
				<?php echo format_phone_link( $org, 'org_phone' ) ?>
			</dd>
		<?php endif; ?>

		<?php if( isset( $org['org_departments'] ) && $org['org_departments'] ) : ?>
			Departments
			<ul class="pl-4">
				<?php
				foreach( $org['org_departments'] as $dept ) :
					$dept_name = ( isset( $dept['dept_name'] ) && ! empty( $dept['dept_name'] ) ) ? $dept['dept_name'] . '<br>' : '';
					$dept_building = ( isset( $dept['dept_building'] ) && ! empty( $dept['dept_building'] ) ) ? $dept['dept_building'] : '';
					$dept_room = ( isset( $dept['dept_room'] ) && ! empty( $dept['dept_room'] ) ) ? ', Room ' . $dept['dept_room']: '';
					$dept_phone = ( isset( $dept['dept_phone'] ) && ! empty( $dept['dept_phone'] ) ) ? '<br>' . format_phone_link( $dept, 'dept_phone' ) : '';
				?>
				<li>
					<?php
						echo $dept_name;
						echo $dept_building;
						echo $dept_room;
						echo $dept_phone;
					?>
				</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
			</div>
		<?php
	return ob_get_clean();

}

/**
 * Returns formatted spotlight markup.
 *
 * @author RJ Bruneel
 * @since 3.5.1
 * @param object $post The post object
 * @return string The spotlight markup
*/
function get_location_spotlight( $post ) {
	if( isset( $post->meta['ucf_location_spotlight'] ) && $post->meta['ucf_location_spotlight'] ) :
		$spotlight = do_shortcode( '[ucf-spotlight slug="' . $post->meta['ucf_location_spotlight']->post_name . '"]' );
		return '<div class="my-5 mt-lg-0">' . $spotlight . '</div>';
	endif;

	return '';
}

/**
 * Returns a formatted list of location organizations.
 *
 * @author RJ Bruneel
 * @since 3.2.8
 * @param object $post The post object
 * @return string The location organizations markup
*/
function get_location_organizations( $post ) {
	ob_start();

	if( isset( $post->meta['ucf_location_orgs'] ) && $post->meta['ucf_location_orgs'] ) : ?>

		<h2 class="h5 heading-underline">Organizations</h2>
		<dl>
		<?php
			$orgs = $post->meta['ucf_location_orgs'];
			$count = 0;

			// $org is not an array if it contains only one item
			if( isset( $orgs['org_name'] ) ) :
				$org = $orgs;
				echo get_organization_html( $post->post_title, $org, $count );
			else :
				foreach( $orgs as $org ) :
					$count++;
					echo get_organization_html( $post->post_title, $org, $count );
				endforeach;
			endif;
		?>
		</dl>

	<?php endif;

	return ob_get_clean();
}


/**
 * Returns a lat+lng string suitable for use in
 * map embed/link query params.
 *
 * @since 3.3.8
 * @author Jo Dickson
 * @param object WP_Post object representing the location
 * @return mixed lat+lng string, or null if no valid lat+lng combination is available
 */
function get_location_latlng_str( $location ) {
	$lat_lng_str = null;
	if ( ! ( $location instanceof WP_Post ) ) return $lat_lng_str;

	$lat_lng = $location->meta['ucf_location_lat_lng'];
	if (
		isset( $lat_lng['ucf_location_lat'] )
		&& ! empty( $lat_lng['ucf_location_lat'] )
		&& isset( $lat_lng['ucf_location_lng'] )
		&& ! empty( $lat_lng['ucf_location_lng'] )
	) {
		$lat_lng_str = $lat_lng['ucf_location_lat'] . ',' . $lat_lng['ucf_location_lng'];
	}

	return $lat_lng_str;
}


?>
