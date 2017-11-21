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
	<a class="btn btn-lg btn-block btn-primary" href="<?php echo $apply_url; ?>">
		<span class="fa fa-pencil"></span> Apply Now
	</a>
<?php
	return ob_get_clean();
}

function get_degree_visit_ucf_button() {
	$url = get_theme_mod( 'degrees_visit_ucf_url' );

	ob_start();

	if ( $url ) :
?>
	<a class="btn btn-lg btn-block btn-primary" href="<?php echo $url; ?>">
		<span class="fa fa-map-marker"></span> Visit UCF
	</a>
<?php
	endif;
	return ob_get_clean();
}

function get_colleges_markup( $post_id ) {
	$colleges = wp_get_post_terms( $post_id, 'colleges' );

	ob_start();
	foreach( $colleges as $college ) :
		$college_url = get_term_meta( $college->term_id, 'colleges_url', true );
		if ( $college_url ) :
?>
		<a href="<?php echo $college_url; ?>" class="d-block text-inverse">
		<?php echo $college->name; ?>
		</a>
<?php 	else : ?>
		<span class="d-block text-inverse">
		<?php echo $college->name; ?>
		</span>
<?php
		endif;
	endforeach;

	return ob_get_clean();
}

function get_departments_markup( $post_id ) {
	$departments = wp_get_post_terms( $post_id, 'departments' );

	ob_start();
	foreach( $departments as $department ) :
		$department_url = get_term_meta( $department->term_id, 'departments_url', true );
		if ( $department_url ) :
?>
		<a href="<?php echo $department_url; ?>" class="d-block text-inverse">
		<?php echo $department->name; ?>
		</a>
<?php 	else : ?>
		<span class="d-block text-inverse">
		<?php echo $department->name; ?>
		</span>
<?php
		endif;
	endforeach;

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

/** Degree Search Typeahead Functions */
function main_site_degree_search_display( $output ) {
	ob_start();
?>
	<form id="degree-search" action="<?php echo get_permalink( get_page_by_path( 'degree-search' ) );?>" method="GET">
		<div class="input-group degree-search">
			<input type="text" name="search" class="form-control degree-search-typeahead" placeholder="Search for degree programs">
			<span class="input-group-btn">
				<button id="ucf-degree-search-submit" type="submit" class="btn btn-degree-search btn-default" aria-label="Search Degrees"><span class="fa fa-search" aria-hidden="true"></span></button>
			</span>
		</div>
	</form>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_degree_search_display', 'main_site_degree_search_display', 11, 1 );

function main_site_degree_search_suggestion() {
	ob_start();
?>
	<p class="ucf-degree-search-suggestion tt-suggestion">
		{{ title.rendered }} <em class="suggestion-match-type text-capitalize">{{ matchString }}</em>
	</p>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_degree_search_suggestion', 'main_site_degree_search_suggestion', 11, 0 );
