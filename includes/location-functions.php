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

	$campus = ( isset( $post->meta['ucf_location_campus'] ) ) ? $post->meta['ucf_location_campus']->post_title : null;
	$abbr = isset( $post->meta['ucf_location_abbr'] ) ? $post->meta['ucf_location_abbr'] : null;
	$id = ( isset( $post->meta['ucf_location_id'] ) && $post->meta['ucf_location_id'] !== $post_name  ) ? $post->meta['ucf_location_id'] : null;

	$lat_lng = ( isset( $post->meta['ucf_location_lat_lng'] ) ) ? $post->meta['ucf_location_lat_lng'] : null;
	$google_map_link = ( $lat_lng ) ? "https://www.google.com/maps?saddr=&daddr=" . $lat_lng["ucf_location_lat"] . "," . $lat_lng["ucf_location_lng"] : "";

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
			<div class="col-6 text-uppercase font-weight-bold">
				Abbreviation</div>
			<div class="col-6"><?php echo $abbr ?></div>
		</div>
	<?php endif; ?>
	<?php if( $id ) : ?>
		<div class="row">
			<div class="col-6 text-uppercase font-weight-bold">Location ID</div>
			<div class="col-6"><?php echo $id ?></div>
		</div>
	<?php endif; ?>
	<?php if( ! empty( $google_map_link ) ) : ?>
		<a href="<?php echo $google_map_link; ?>" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm text-uppercase mb-4 mt-3">
			<span class="fa fa-location-arrow"></span>
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
			<a href="#collapse<?php echo $count; ?>" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapse<?php echo $count; ?>">
				<?php echo $org['org_name']; ?>
			</a>
		</dt>
	<?php endif; ?>

	<div class="collapse pb-2" id="collapse<?php echo $count; ?>">

		<?php if ( isset( $org['org_room'] ) && ! empty( $org['org_room'] ) ) : ?>
			<dd class="mb-0">
				 <?php echo $title ?> Room <?php echo $org['org_room']; ?>
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
					$dept_name = ( isset( $dept['dept_name'] ) && ! empty( $dept['dept_name'] ) ) ? ' Room ' . $dept['dept_name'] . '<br>' : '';
					$dept_building = ( isset( $dept['dept_building'] ) && ! empty( $dept['dept_building'] ) ) ? $dept['dept_building'] : '';
					$dept_room = ( isset( $dept['dept_room'] ) && ! empty( $dept['dept_room'] ) ) ? ' Room ' . $dept['dept_room'] . '<br>' : '';
					$dept_phone = ( isset( $dept['dept_phone'] ) && ! empty( $dept['dept_phone'] ) ) ? format_phone_link( $dept, 'dept_phone' ) . '<br>' : '';
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
		$markup = ob_get_clean();
	}

	return $markup;
}

add_filter( 'get_header_content_title_subtitle', 'get_header_content_custom_location', 10, 2 );
?>
