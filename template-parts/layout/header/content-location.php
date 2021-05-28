<?php
/**
 * Markup for single Location header content.
 */

$obj     = get_queried_object();
$title   = $obj->post_title;
$address = isset( $obj->meta['ucf_location_address'] ) ?
			$obj->meta['ucf_location_address'] :
			null;
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
