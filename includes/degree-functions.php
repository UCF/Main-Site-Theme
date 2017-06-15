<?php
/**
 * Functions specific to degrees
 **/

/**
 * Gets the "Apply Now" button markup for degree.
 * @author Jim Barnes
 * @since 3.0.0
 * @param $post_meta Array | An array of post meta data
 * @return string | The button markup.
 **/
function get_degree_apply_button( $post_meta ) {
	$apply_url = '';

	if ( isset( $post_meta['degree_is_graduate'] ) && $post_meta['degree_is_graduate'] === true ) {
		$apply_url = get_theme_mod( 'degree_graduate_application' );
	} else {
		$apply_url = get_theme_mod( 'degree_undergraduate_application' );
	}

	ob_start();
?>
	<a class="btn btn-lg btn-block bg-primary" href="<?php echo $apply_url; ?>">
		<span class="fa fa-pencil"></span> Apply Now
	</a>
<?php
	return ob_get_clean();
}

function get_degree_tuition_markup( $post_meta ) {
	$resident = isset( $post_meta['degree_resident_tuition'] ) ? $post_meta['degree_resident_tuition'] : null;
	$nonresident = isset( $post_meta['degree_nonresident_tuition'] ) ? $post_meta['degree_nonresident_tuition'] : null;

	if ( $resident && $nonresident ) {
		return ucf_tuition_fees_degree_layout( $resident, $nonresident );
	}
}

function ucf_tuition_fees_degree_layout( $resident, $nonresident ) {
	$value_message = get_theme_mod( 'tuition_value_message', null );
	$disclaimer = get_theme_mod( 'tuition_disclaimer', null );

	ob_start();
?>
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#in-state" role="tab">In State</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#out-of-state" role="tab">Out of State</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="in-state" role="tabpanel">
			<div class="p-4">
				<?php if ( $value_message ) : ?>
				<?php echo apply_filters( 'the_content', $value_message ); ?>
				<?php endif; ?>
				<div class="bg-primary-lighter p-4">
					<p class="text-center font-weight-bold">
						<?php echo $resident; ?><?php if ( $disclaimer ) echo '*'; ?>
					</p>
				<?php if ( $disclaimer ) : ?>
					<p><small><?php echo $disclaimer; ?></small></p>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="out-of-state" role="tabpanel">
			<div class="p-4">
				<?php if ( $value_message ) : ?>
				<?php echo apply_filters( 'the_content', $value_message ); ?>
				<?php endif; ?>
				<div class="bg-primary-lighter p-4">
					<p class="text-center font-weight-bold">
						<?php echo $nonresident; ?><?php if ( $disclaimer ) echo '*'; ?>
					</p>
				<?php if ( $disclaimer ) : ?>
					<p><small><?php echo $disclaimer; ?></small></p>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php
	return ob_get_clean();
}
