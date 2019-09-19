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
	$campus = isset( $post->meta['ucf_location_campus'] ) ? $post->meta['ucf_location_campus'] : null;
	if( $campus ) {
		$campus = 'Campus: ' . $campus->post_title . '<br>';
	} else {
		$campus = "";
	}

	$abbr = isset( $post->meta['ucf_location_abbr'] ) ? $post->meta['ucf_location_abbr'] : null;

	$id = isset( $post->meta['ucf_location_id'] ) ? $post->meta['ucf_location_id'] : null;
	$id = ( isset( $id ) && $id !== $post_name ) ? "Location ID: $id" : "";

	$abbr = ( $abbr ) ? "Abbreviation: $abbr<br>" : "";
	$lat_lng = $post->meta['ucf_location_lat_lng'];
	$google_map_link = ( $lat_lng ) ? "https://www.google.com/maps?saddr=&daddr=" . $lat_lng["ucf_location_lat"] . "," . $lat_lng["ucf_location_lng"] : "";

	ob_start();
?>
	<p>
		<?php echo $campus; ?>
		<?php echo $abbr; ?>
		<?php echo $id; ?>
	</p>

	<?php if( ! empty( $google_map_link ) ) : ?>
		<a href="<?php echo $google_map_link; ?>" target="_blank" rel="noopener" class="btn btn-secondary btn-sm text-uppercase mb-4 mt-2">Get Directions</a>
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
	if ( isset( $org['org_name'] ) && ! empty( $org['org_name'] ) ) {
		echo '<dt><a href="#collapse' . $count . '" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse' . $count . '">' . $org['org_name'] . '</a></dt>';
	}
	echo '<div class="collapse mb-4" id="collapse' . $count . '">';
		echo ( isset( $org['org_room'] ) && ! empty( $org['org_room'] ) ) ? '<dd class="mb-0">' . $title . ' Room ' . $org['org_room'] . '</dd>' : '';
		echo ( isset( $org['org_phone'] ) && ! empty( $org['org_phone'] ) ) ? '<dd>' . format_phone_link( $org, 'org_phone' ) . '</dd>' : '';

		if( isset( $org['org_departments'] ) && $org['org_departments'] ) :
			echo 'Departments';
			echo '<ul class="pl-4">';
			foreach( $org['org_departments'] as $dept ) :
				echo '<li>' . $dept['dept_name'] . '<br>';
				echo ( isset( $dept['dept_building'] ) && ! empty( $dept['dept_building'] ) ) ? $dept['dept_building'] : '';
				echo ( isset( $dept['dept_room'] ) && ! empty( $dept['dept_room'] ) ) ? ' Room ' . $dept['dept_room'] . '<br>' : '';
				echo ( isset( $dept['dept_phone'] ) && ! empty( $dept['dept_phone'] ) ) ? format_phone_link( $dept, 'dept_phone' ) . '<br>' : '';
				echo '</li>';
			endforeach;
			echo '</ul>';
		endif;
	echo "</div>";
}

/**
 * Returns a formatted list of location organizations.
 *
 * @author RJ Bruneel
 * @since 3.2.8
 * @param string $markup The passed in markup
 * @param object $post The post object
 * @return string The header markup
*/
function get_location_organizations( $post ) {
	ob_start();

	if( isset( $post->meta['ucf_location_orgs'] ) && $post->meta['ucf_location_orgs'] ) : ?>

		<h3 class="h5 heading-underline">Organizations</h3>
		<dl>
		<?php
			$orgs = $post->meta['ucf_location_orgs'];
			$count = 0;

			// $org is not an array if it contains only one item
			if( isset( $orgs['org_name'] ) ) :
				$org = $orgs;
				get_organization_html( $post->post_title, $org, $count );
			else :
				foreach( $orgs as $org ) :
					$count++;
					get_organization_html( $post->post_title, $org, $count );
				endforeach;
			endif;
		?>
		</dl>

	<?php endif;

	return ob_get_clean();
}

/**
 * Filter for setting the custom header content
 * @author Jim Barnes
 * @since 3.2.8
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
?>
