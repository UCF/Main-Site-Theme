<?php
/**
 * Functions specific to degrees
 **/

/**
 * Returns the child program_type assigned to the given degree.
 *
 * @since 3.1.0
 * @author Jo Dickson
 * @param object $degree  WP_Post object
 * @return mixed  WP_Term object, or null on failure
 */
function get_degree_program_type( $degree ) {
	$retval = null;
	$args   = array( 'childless' => true );
	$terms  = wp_get_post_terms( $degree->ID, 'program_types', $args );

	if ( !empty( $terms ) && ! is_wp_error( $terms ) ) {
		$retval = $terms[0];
	}

	return $retval;
}

/**
 * Returns true|false if program_type is a graduate program.
 *
 * @since 3.3.8
 * @author RJ Bruneel
 * @param object $degree  WP_Post object
 * @return boolean
 */
function is_graduate_degree( $post ) {
	$is_graduate = false;
	$terms = wp_get_post_terms( $post->ID, 'program_types' );

	foreach( $terms as $term ) {
		if( $term->slug === "graduate-program" ) {
			$is_graduate = true;
			break;
		}
	}
	return $is_graduate;
}

/**
 * Gets the "Apply Now" button markup for degree.
 * @author Jim Barnes
 * @since 3.0.0
 * @param object $degree | WP_Post object for the degree
 * @return string | The button markup.
 **/
function get_degree_apply_button( $degree ) {
	$apply_url = '';

	$type = get_degree_program_type( $degree );
	if ( ! $type ) { return $apply_url; }
	$type_parent = get_term( $type->parent, 'program_types' );
	$type_parent = ( ! is_wp_error( $type_parent ) && !empty( $type_parent ) ) ? $type_parent : null;

	if ( $type->name === 'Graduate Program' || ( $type_parent && $type_parent->name === 'Graduate Program' ) ) {
		$apply_url = get_theme_mod_or_default( 'degrees_graduate_application' );
	}
	else if ( $type->name === 'Undergraduate Program' || ( $type_parent && $type_parent->name === 'Undergraduate Program' ) ) {
		$apply_url = get_theme_mod_or_default( 'degrees_undergraduate_application' );
	}

	ob_start();

	if ( ! empty( $apply_url ) ):
?>
	<a class="btn btn-lg btn-block btn-primary" href="<?php echo $apply_url; ?>">
		<span class="fa fa-pencil pr-2" aria-hidden="true"></span> Apply Now
	</a>
<?php
	endif;

	return ob_get_clean();
}

/**
 * Gets the "Request Info" button markup for degree.
 * @author RJ Bruneel
 * @since 3.3.8
 * @return string | The button markup.
 **/
function get_degree_request_info_ucf_button() {
	$url = get_theme_mod_or_default( 'degrees_visit_ucf_url' );
	$url = true;

	ob_start();

	if ( $url ) :
?>
	<button type="button" class="btn btn-lg btn-block btn-primary"
		data-toggle="modal" data-target="#requestInfoModal">
		<span class="fa fa-map-marker pr-2" aria-hidden="true"></span> Request Info
	</button>
<?php
	endif;
	return ob_get_clean();
}

/**
 * Gets the "Request Info" modal markup for degree.
 * @author RJ Bruneel
 * @since 3.3.8
 * @return string | The modal markup.
 **/
function get_degree_request_info_ucf_modal(  ) {
	ob_start();
	$planSubPlan = get_field('degree_plan_code') . get_field('degree_subplan_code');
	$selectedDegree = getPrograms()[$planSubPlan];
?>
	<div class="modal fade" id="requestInfoModal" tabindex="-1" role="dialog"
		aria-labelledby="requestInfoModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="requestInfoModalLabel">Request Info</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="form_bad6c39a-5c60-4895-9128-5785ce014085">Loading...</div><script>/*<![CDATA[*/var script = document.createElement('script'); script.async = 1; script.src = 'https://applynow.graduate.ucf.edu/register/?id=bad6c39a-5c60-4895-9128-5785ce014085&sys:field:pros_program1=<?php echo $selectedDegree; ?>&output=embed&div=form_bad6c39a-5c60-4895-9128-5785ce014085' + ((location.search.length > 1) ? '&' + location.search.substring(1) : ''); var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(script, s);/*]]>*/</script>

				</div>
			</div>
		</div>
	</div>
<?php
	return ob_get_clean();
}

function get_degree_visit_ucf_button() {
	$url = get_theme_mod_or_default( 'degrees_visit_ucf_url' );

	ob_start();

	if ( $url ) :
?>
	<a class="btn btn-lg btn-block btn-primary" href="<?php echo $url; ?>">
		<span class="fa fa-map-marker pr-2" aria-hidden="true"></span> Visit UCF
	</a>
<?php
	endif;
	return ob_get_clean();
}

function get_colleges_markup( $post_id ) {
	$colleges = wp_get_post_terms( $post_id, 'colleges' );

	ob_start();
	foreach( $colleges as $college ) :
		$college_url = get_term_link( $college->term_id );
		if ( $college_url ) :
?>
		<a href="<?php echo $college_url; ?>" class="d-block">
		<?php echo $college->name; ?>
		</a>
<?php 	else : ?>
		<span class="d-block">
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
		<a href="<?php echo $department_url; ?>" class="d-block">
		<?php echo $department->name; ?>
		</a>
<?php 	else : ?>
		<span class="d-block">
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
	$skip = ( isset( $post_meta['degree_tuition_skip'] ) && $post_meta['degree_tuition_skip'] === 'on' ) ? true : false;

	if ( $resident && $nonresident && ! $skip ) {
		return ucf_tuition_fees_degree_layout( $resident, $nonresident );
	}

	return '';
}

function ucf_tuition_fees_degree_layout( $resident, $nonresident ) {
	$value_message = get_theme_mod( 'tuition_value_message', null );
	$disclaimer = get_theme_mod( 'tuition_disclaimer', null );

	ob_start();
?>
	<h2 class="h4 mb-4">Tuition and Fees</h2>
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#in-state" role="tab">In State</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#out-of-state" role="tab">Out of State</a>
		</li>
	</ul>
	<div class="tab-content pt-4 mb-4 mb-md-5">
		<div class="tab-pane active" id="in-state" role="tabpanel">
			<?php if ( $value_message ) : ?>
			<?php echo apply_filters( 'the_content', $value_message ); ?>
			<?php endif; ?>
			<div class="bg-primary-lighter p-4">
				<p class="h5 text-center font-weight-bold mb-0">
					<?php echo $resident; ?>
				</p>
			<?php if ( $disclaimer ) : ?>
				<p class="mt-3 mb-0"><small><?php echo $disclaimer; ?></small></p>
			<?php endif; ?>
			</div>
		</div>
		<div class="tab-pane" id="out-of-state" role="tabpanel">
			<?php if ( $value_message ) : ?>
			<?php echo apply_filters( 'the_content', $value_message ); ?>
			<?php endif; ?>
			<div class="bg-primary-lighter p-4">
				<p class="h5 text-center font-weight-bold mb-0">
					<?php echo $nonresident; ?>
				</p>
			<?php if ( $disclaimer ) : ?>
				<p class="mt-3 mb-0"><small><?php echo $disclaimer; ?></small></p>
			<?php endif; ?>
			</div>
		</div>
	</div>
<?php
	return ob_get_clean();
}


/**
 * Returns the markup for breadcrumbs for a single degree profile.
 *
 * @author Jo Dickson
 * @since v3.0.5
 * @param int $post_id ID of the degree post
 * @return string HTML markup for the degree's breadcrumbs
 */
function get_degree_breadcrumb_markup( $post_id ) {
	$degree = get_post( $post_id );
	if ( !$degree || ( $degree && $degree->post_type !== 'degree' ) ) { return; }

	$program_type          = get_degree_program_type( $degree );
	$colleges              = wp_get_post_terms( $post_id, 'colleges' );
	$college               = is_array( $colleges ) ? $colleges[0] : null;

	$program_type_url_part = $program_type ? $program_type->slug . '/' : '';
	$college_url_part      = $college ? 'college/' . $college->slug . '/' : '';

	$degree_search_url     = get_permalink( get_page_by_title( 'Degree Search' ) );
	$college_url           = $degree_search_url . '#!/' . $college_url_part;
	$program_type_url      = $degree_search_url . '#!/' . $college_url_part . $program_type_url_part;

	ob_start();
?>
<div class="hidden-md-down">
	<hr class="mt-5 mb-4">
	<nav class="breadcrumb" aria-label="Breadcrumb">
		<a class="breadcrumb-item" href="<?php echo $degree_search_url; ?>">Degree Search</a>

		<?php if ( $college ): ?>
		<a class="breadcrumb-item" href="<?php echo $college_url; ?>"><?php echo $college->name; ?></a>
		<?php endif; ?>

		<?php if ( $program_type ) : ?>
		<a class="breadcrumb-item" href="<?php echo $program_type_url; ?>"><?php echo $program_type->name; ?>s</a>
		<?php endif; ?>

		<span class="breadcrumb-item active" aria-current="page"><?php echo $degree->post_title; ?></span>
	</nav>
</div>
<?php
	return ob_get_clean();
}


/** Degree Search Typeahead Functions */
function main_site_degree_search_display( $output, $args ) {
	ob_start();
?>
	<form id="degree-search" action="<?php echo get_permalink( get_page_by_path( 'degree-search' ) );?>" method="GET">
		<div class="input-group degree-search">
			<input type="text" name="search" class="form-control degree-search-typeahead" aria-label="Search degree programs" placeholder="<?php echo $args['placeholder']; ?>">
			<span class="input-group-btn">
				<button id="ucf-degree-search-submit" type="submit" class="btn btn-degree-search btn-primary text-inverse" aria-label="Search"><span class="fa fa-search" aria-hidden="true"></span></button>
			</span>
		</div>
	</form>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_degree_search_input', 'main_site_degree_search_display', 11, 2 );

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

// College tax functions
function map_degree_types( $degree_types ) {
	$retval = array();

	if ( ! empty( $degree_types ) ) {
		foreach( $degree_types as $degree_type ) {
			$term = get_term_by( 'slug', $degree_type, 'program_types' );

			if ( $term ) {
				$retval[$term->slug] = $term->name;
			}
		}
	}

	return $retval;
}


/**
 * Helper function that returns the catalog description for the given
 * UCF Search Service program object.
 *
 * @since 3.1.0
 * @author Jo Dickson
 * @param object $program  A single program object from the UCF Search Service
 * @return string  The program's catalog description
 */
function get_api_catalog_description( $program ) {
	$retval = '';

	if ( ! class_exists( 'UCF_Degree_Config' ) ) {
		return $retval;
	}

	// Determine the catalog description type's ID
	$description_types = UCF_Degree_Config::get_description_types();
	$catalog_desc_type_id = null;

	if ( $description_types ) {
		foreach ( $description_types as $desc_id => $desc_name ) {
			if ( stripos( $desc_name, 'Catalog Description' ) !== false ) {
				$catalog_desc_type_id = $desc_id;
				break;
			}
		}
	}

	// Find the program's description by the catalog description type ID
	$descriptions = $program->descriptions;

	if ( !empty( $descriptions ) && $catalog_desc_type_id ) {
		foreach ( $descriptions as $d ) {
			if ( $d->description_type->id === $catalog_desc_type_id ) {
				$retval = $d->description;
			}
		}
	}

	return $retval;
}

/**
 * Apply main site-specific meta data to degrees during the degree import
 * process.
 *
 * @since 3.0.5
 * @author Jo Dickson
 */
function mainsite_degree_format_post_data( $meta, $program ) {
	$meta['page_header_height'] = 'header-media-default';
	$meta['degree_description'] = get_api_catalog_description( $program );

	return $meta;
}

add_filter( 'ucf_degree_get_post_metadata', 'mainsite_degree_format_post_data', 10, 2 );


/**
 * Angular Degree Template Overrides
 */

function main_site_degree_search_program_types() {
	ob_start();
?>
	<div class="degree-search-types" ng-controller="ProgramController as programCtl" ng-init="programCtl.init()">
		<a href ng-class="{'active': mainCtl.selectedProgramType === 'all'}" ng-click="programCtl.onClear()">View All</a>
		<ul class="degree-search-program-types list-unstyled">
			<li class="degree-search-type" ng-repeat="(key, type) in programCtl.programTypes">
				<a href ng-class="{'active': mainCtl.selectedProgramType === type.slug}" ng-click="programCtl.onSelected(type.slug)">{{ type.name }}</a>
				<ul class="degree-search-type-children list-unstyled ml-3" ng-if="type.children && mainCtl.selectedParentProgramType == type.slug">
					<li class="degree-search-child-type" ng-repeat="(subkey, subtype) in type.children">
						<a href ng-class="{'active': mainCtl.selectedProgramType === subtype.slug}" ng-click="programCtl.onSelected(subtype.slug)">{{ subtype.name }}</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
<?php
	return ob_get_clean();
}

add_filter( 'udsa_program_types_template', 'main_site_degree_search_program_types', 10, 0 );

function main_site_degree_search_colleges() {
	ob_start();
?>
	<div class="degree-search-colleges" ng-controller="CollegeController as collegeCtl" ng-init="collegeCtl.init()">
		<a href ng-class="{'active': mainCtl.selectedCollege == 'all'}" ng-click="collegeCtl.onClear()">View All</a>
		<ul class="degree-search-colleges list-unstyled">
			<li class="degree-search-college" ng-repeat="(key, college) in collegeCtl.colleges">
				<a href ng-class="{'active': mainCtl.selectedCollege == college.slug}" ng-click="collegeCtl.onSelected(college.slug)">{{ college.name }}</a>
			</li>
		</ul>
	</div>
<?php
	return ob_get_clean();
}

add_filter( 'udsa_colleges_template', 'main_site_degree_search_colleges', 10, 0 );

function main_site_degree_search_result_count() {
	ob_start();
?>
	<p class="text-muted my-3" ng-if="mainCtl.totalResults > 0">
		{{ mainCtl.resultMessage }}
	</p>
<?php
	return ob_get_clean();
}

add_filter( 'udsa_result_count_template', 'main_site_degree_search_result_count', 10, 0 );

function main_site_degree_display_subplans( $post_id ) {
	$children = get_children( array(
		'post_parent' => $post_id,
		'post_type'   => 'degree',
		'numberposts' => -1,
		'post_status' => 'publish'
	) );

	if ( $children ) :
?>
	<h3>Related Programs</h3>
	<ul>
	<?php foreach( $children as $child ) : ?>
		<li><a href="<?php echo get_permalink( $child->ID ); ?>"><?php echo $child->post_title; ?></a></li>
	<?php endforeach; ?>
	</ul>
<?php
	endif;

	return ob_get_clean();
}

/**
 * Formats degree meta
 * @author Jim Barnes
 * @since 3.4.0
 * @param array $post_meta The post_meta array
 * @return array
 */
function main_site_format_degree_data( $post_meta ) {
	setlocale(LC_MONETARY, 'en_US');

	if ( isset( $post_meta['degree_avg_annual_earnings'] ) && ! empty( $post_meta['degree_avg_annual_earnings'] ) ) {
		$post_meta['degree_avg_annual_earnings'] = money_format( '%n', floatval( $post_meta['degree_avg_annual_earnings'] ) );
	}

	if ( isset( $post_meta['degree_employed_full_time'] ) && ! empty( $post_meta['degree_employed_full_time'] ) ) {
		$post_meta['degree_employed_full_time'] = number_format( floatval( $post_meta['degree_employed_full_time'] ) ) . '%';
	}

	if ( isset( $post_meta['degree_continuing_education'] ) && ! empty( $post_meta['degree_continuing_education'] ) ) {
		$post_meta['degree_continuing_education'] = number_format( floatval( $post_meta['degree_continuing_education'] ) ) . '%';
	}

	if ( isset( $post_meta['degree_prj_begin_employment'] ) &&  ! empty( 'degree_prj_begin_employment' ) ) {
		$post_meta['degree_prj_begin_employment'] = number_format( floatval( $post_meta['degree_prj_begin_employment'] ) );
	}

	if ( isset( $post_meta['degree_prj_end_employment'] ) &&  ! empty( $post_meta['degree_prj_end_employment'] ) ) {
		$post_meta['degree_prj_end_employment'] = number_format( floatval( $post_meta['degree_prj_end_employment'] ) );
	}

	if ( isset( $post_meta['degree_prj_change'] ) &&  ! empty( $post_meta['degree_prj_change'] ) ) {
		$post_meta['degree_prj_change'] = number_format( floatval( $post_meta['degree_prj_change'] ) );
	}

	if ( isset( $post_meta['degree_prj_change_percentage'] ) &&  ! empty( $post_meta['degree_prj_change_percentage'] ) ) {
		$post_meta['degree_prj_change_percentage'] = number_format( floatval( $post_meta['degree_prj_change_percentage'] ), 2 ) . '%';
	}

	if ( isset( $post_meta['degree_prj_openings'] ) && ! empty( $post_meta['degree_prj_openings'] ) ) {
		$post_meta['degree_prj_openings'] = number_format( floatval( $post_meta['degree_prj_openings'] ) );
	}

	return $post_meta;
}

/**
 * Formats the outcome data
 * @author Jim Barnes
 * @since 3.4.0
 * @param array $post_meta The formatted post_meta array
 * @return string
 */
function main_site_outcome_data( $post_meta ) {
	ob_start();
	$keys = array(
		'degree_avg_annual_earnings',
		'degree_employed_full_time'
	);

	$display = isset( $post_meta['degree_display_outcomes'] ) ?
		filter_var( $post_meta['degree_display_outcomes'], FILTER_VALIDATE_BOOLEAN ) :
		false;

	if ( count( array_intersect( array_keys( $post_meta ), $keys ) ) > 0 && $display ) :

		$report_year = isset( $post_meta['degree_outcome_academic_year'] ) ?
			'(per ' . $post_meta['degree_outcome_academic_year'] . ' Data)' :
			'';
?>
	<?php if ( isset( $post_meta['degree_employed_full_time'] ) ) : ?>
	<p>UCF Alumni Working full-time: <?php echo $post_meta['degree_employed_full_time']; ?> <?php echo $report_year; ?></p>
	<?php endif; ?>
	<?php if ( isset( $post_meta['degree_avg_annual_earnings'] ) ) : ?>
	<p>UCF Alumni Average Annual Earnings: <?php echo $post_meta['degree_avg_annual_earnings']; ?> <?php echo $report_year; ?></p>
	<?php endif; ?>
<?php
	endif;

	return ob_get_clean();
}

/**
 * Formats the projection data
 * @author Jim Barnes
 * @since 3.4.0
 * @param array $post_meta The formatted post_meta array
 * @return string
 */
function main_site_projection_data( $post_meta ) {
	ob_start();

	$keys = array(
		'degree_prj_openings',
		'degree_prj_change'
	);

	$display = isset( $post_meta['degree_display_projections'] ) ?
		filter_var( $post_meta['degree_display_projections'], FILTER_VALIDATE_BOOLEAN ) :
		false;

	if ( count( array_intersect( array_keys( $post_meta ), $keys ) ) > 0 && $display ) :
?>
	<?php if ( isset( $post_meta['degree_prj_begin_year'] ) && isset( $post_meta['degree_prj_end_year'] ) ) : ?>
	<p>Projected <?php echo $post_meta['degree_prj_begin_year']; ?>-<?php echo $post_meta['degree_prj_end_year']; ?>
	<?php endif; ?>
	<?php if ( isset( $post_meta['degree_prj_openings'] ) ) : ?>
	<p>Job Openings: <?php echo $post_meta['degree_prj_openings']; ?></p>
	<?php endif; ?>
	<?php if ( isset( $post_meta['degree_prj_change'] ) ) : ?>
	<p>New Jobs: <?php echo $post_meta['degree_prj_change']; ?>
	<?php endif; ?>
<?php
	endif;

	return ob_get_clean();
}

/**
 * Returns the news shortcode for degrees
 * @author Jim Barnes
 * @since v3.4.0
 * @param array $post_meta The post meta array
 * @return string
 */
function main_site_degree_news_stories( $post_meta ) {
	ob_start();

	$display = isset( $post_meta['degree_display_news'] ) ?
		filter_var( $post_meta['degree_display_news'], FILTER_VALIDATE_BOOLEAN ) :
		false;

	$tag = isset( $post_meta['degree_news_tag'] ) ? $post_meta['degree_news_tag'] : null;

	if ( $display && ! empty( $tag ) ) :
?>
		[ucf-news-feed topics="<?php echo $tag; ?>"]
<?php
	endif;

	return do_shortcode( ob_get_clean() );
}

/**
 * Returns a list of careers for a degree
 * @author Jim Barnes
 * @since v3.4.0
 * @param int $post_id The post id
 * @return string
 */
function main_site_degree_careers( $post_id, $post_meta ) {
	$display = isset( $post_meta['degree_display_career_paths'] ) ?
		filter_var( $post_meta['degree_display_career_paths'], FILTER_VALIDATE_BOOLEAN )
		: false;

	$terms = wp_get_post_terms(
		$post_id,
		'career_paths'
	);

	shuffle( $terms );

	$terms = array_slice( $terms, 0, 10 );

	usort( $terms, function($a, $b) {
		return strcmp( $a->name, $b->name );
	} );

	ob_start();

	if ( count( $terms ) > 0 && $display ) :
?>
	<h3>Careers</h3>
	<ul>
<?php foreach( $terms as $term ) : ?>
		<li><?php echo $term->name; ?></li>
<?php endforeach; ?>
	</ul>
<?php
	endif;

	return ob_get_clean();
}

function getPrograms() {
	return array(
		"ACADVISCRT" => "372e75f2-2c98-4b8b-b883-9304234e33aa","ACCTG-MSA" => "6633da07-2672-41f4-a211-a07fb7504b3b","NURAGACNPC" => "f4436925-c286-4368-9e30-7d58aa072d06","DNPAGNPC" => "eb83ad6d-e785-4d1c-8c12-bc249ca4fff6","AQMEDHUMSC" => "f43eec15-a0fc-4a70-9193-4fb7488f8bf8","AEROENG-MS" => "c84c72ba-1525-473a-9e4c-d6f9a84a0ed1","AEROENG-MSACCB2MMSAE" => "29180310-08e5-45b8-a2a6-5c586f537513","AEROENG-MSSPSYSDES-M" => "fb54ed67-07ac-422f-a20d-63e35227337f","AEROENG-MSTHRMAERO-M" => "d1376acb-264d-4bda-9ac2-eaa759cb10ba","AEROENGPHD" => "e92d44e3-8d24-4314-abd0-44766ebe11a0","HPANASCC" => "13025868-6208-4796-aef2-4f5c272e988f","ANTHRO-MA" => "f5bf4b01-aa4e-43ea-a61e-e4619f29877f","APLRNIS-MA" => "5e109eb0-ddf4-4cc1-8978-f58170ae4601","APPLOPRRS" => "08b5e39e-c34c-4f3d-bdf3-552aa5898552","ATHTRMATHT" => "258de8f2-3c81-4724-8584-473e70fea2cd","AUTDISCRT" => "13a5220b-7fe9-4f33-9589-7e6158d98e19","BGDATAAPHD" => "9757150b-aeff-4749-ad64-e04645a36b5e","BIO-MS" => "88fb7e47-5000-4eec-8792-daa999fc193f","BIOMEDEMSBIOBSMSBME" => "eff33f3e-61e6-4604-831d-64eb463a4bb8","BIOMEDEMSBIOFLUIDS" => "eea17c76-80ae-4f11-864a-f123c158d878","BIOMEDEMSBIOMECHAN" => "01313958-cd4f-4384-ba49-59c859307e3e","BIOMEDEMSBIOMDMSBME" => "20de0f2c-8745-4711-934b-548f9648b27c","BIOMSCI-MS" => "0b232f3d-9cd2-437b-9b43-458eb17f785d","BIOMSCI-MSBMSCANBIO" => "76b03764-e4a0-4f35-87fd-937a090ca0c6","BIOMSCI-MSGENTCCOUNS" => "23729dde-eadf-4aeb-8fd5-5d6d13aa8e60","BIOMSCI-MSBMSINFDIS" => "2a6ea58f-9885-4852-aa51-4ba0349404d5","BIOMSCI-MSBMSINTMSCI" => "8aa23f9b-19eb-44ee-8bde-349733cab6db","BIOMSCI-MSBMSMCASC" => "d833bd08-b61d-4b87-ad3a-17cd5f22cf31","BIOMSCI-MSBMSNEUROSC" => "beafe945-90ff-4f46-9400-a1f71e4dfbd1","BIOMOL HPA" => "cf154ba1-7e48-4dbd-8833-202e0e79b4e4","BIOMOL HPABMEDHPA-MD" => "87da75be-31d0-4d5a-8fe6-701aae760957","BIOTECH-MS" => "57b50ede-e3a1-4096-9392-31ab3537a1fa","BIOTECH-MSPSM-BIOTEC" => "390c599c-f009-4df2-91ac-67ca600138e0","BUS-MBAEVNG-MBA" => "7f8497c3-bdcd-4a83-99b6-da51f41ed548","BUS-MBAEXEC-MBA" => "e1f06c47-7c92-4fa8-a476-8262f76d4bfa","BUS-MBAPROF-MBA" => "e11d75e4-1f98-4a21-a3da-b2d79f3c8238","BUS-PHDACCOUNTING" => "5c5ecd0b-4500-4b85-998c-4497adc9351a","BUS-PHDFINANCE" => "66c991ce-d46d-470f-868a-98d042f33ca3","BUS-PHDMANAGEMENT" => "adc9c4b1-8b3c-45b3-9100-b032d98fd504","BUS-PHDMARKETING" => "f726e56d-d086-41c0-a72d-f49b627203f6","VOCED-MA" => "782a79b3-dd6c-4428-bc5e-44d5e89cd1a4","CARCOUNCRT" => "4ec98b1f-d2c9-4993-bdd4-46f4a0bd088e","CHEM-MS" => "20f00512-09c5-4aee-8b74-19368d9a1bdb","CHEM-PHD" => "fb35dae9-1305-4c88-99bb-c5a587396c9c","CIVENGR-MS" => "047fb6ea-8505-4350-ab79-7029b875a157","CIVENGR-MSSMARTCTIES" => "e7f20184-6357-4f47-85c2-d1a88857d392","CIVENGR-MSSTRUCTUR-T" => "ddb0b2e4-c7b7-4b88-9133-4e44777247b0","CIVENGR-MSTRANSP-S" => "01d24493-47b0-40fb-b6f7-2ccf08fe5457","CIVENGR-MSWATERRES" => "5c9de638-fc43-43e8-b7b6-b1e37be9fa29","CIVEN-MSCE" => "4d40e294-26dc-4c79-9c65-74a600453b03","CIVENG-PHD" => "81ca9a77-ebc6-4140-8a7d-ff5af9685ae0","CLINPSY-MACLNPSY-NTH" => "bc869be7-7a22-47df-b172-61b5a434e9bd","CLINPSY-MACLNPSY-RTH" => "c892921b-1989-47eb-8c4e-055f3f58b9c3","PSYCH-PHDCLINICAL" => "1a24e084-db56-4491-b0d7-2a110fe99952","COGSCICRT" => "721c66de-37ca-4886-b89b-31e5f1eb865a","INTVSPECCR" => "5aa85c6e-332b-41c1-b654-dbb1f4ade22b","CICOMMCOLL" => "8a587e88-77c1-486a-8aa1-943e3a2fd4ea","COMM-MA" => "52f28f4a-af3b-4ca8-a0a0-be88b20d3b65","COMM-MAMASSCOMM" => "a2a0c91e-9299-4aaf-997c-3c659e2347b7","COMMDIS-MA" => "85f68397-bdb1-45e4-9906-e97c38800a42","COMMDIS-MAACCELCD-MA" => "26c7873a-1c00-4999-ac10-d043a94b55bd","COMMDIS-MACOMDISCONS" => "26bb95b4-72be-4f5e-92a9-5044ce17fcd9","CMPENGR-MS" => "d16aec6a-7e34-407e-8e44-91902709d0bb","CMPENGR-MSACCB2MMSPE" => "b543bc42-f8ef-4d9e-a223-5eac033e16d4","CMPENG-PHD" => "937c73b5-5027-40aa-894a-465bf4a3d3be","COMPFOREN" => "1fdad468-9fee-4f6d-83c8-ac0f8ce2bbae","COMPSCI-MS" => "dcb6895b-6f9b-4366-8d50-9101cff308a5","COMPSCI-MSACCELBS2MS" => "1a18c76c-6c86-4487-94e6-b2e2ffb56dec","COMPSCIPHD" => "e83c7b7e-7b44-481b-a465-9c7d7b900eea","CORPCOMM" => "d1f351d4-f1df-4520-8030-117f96269cb6","CORRLD" => "7ed74a12-08e2-4833-8f1e-a03863006da2","COUNSED-MAMENTALHLTH" => "f40891b8-388a-4797-9326-f900d29b124e","COUNSED-MASCHCOUN-MA" => "83e32470-5b0b-48d2-ad14-4cf838b109be","COUNSED-MESCHCOUN-ME" => "f831075f-29e1-4a25-90a3-0baa765b7771","CRWRT-MFA" => "d63bb0f2-0d91-47f2-932c-4fee9f3ef6e5","CRIMANACER" => "97eba75d-8836-40b5-8a4a-73d10378879d","CJEXECCERT" => "2acd04ef-492d-4539-9601-d087cf56f9e3","CRIMJUS-MS" => "a14a1681-01cf-4e6f-9c0e-853bb0b36cf0","CRIMJUS-MSPUBADMDD" => "484e2b21-bf07-46de-838d-56615dfef843","CRIMJUSPHD" => "cc2b6105-3a60-4896-a6d5-506877be6f09","CINSTR-EDD" => "ca3882c1-23f7-4208-ac19-592970f867ad","CINSTR-MEDCICULD-MED" => "335aefc9-d1b1-4429-a0e5-488536b997e8","CINSTR-MEDCIEDTE-MED" => "5c0ee947-c962-441e-8864-2abf243c1874","CINSTR-MEDCIGIFE-MED" => "c7d91a08-563b-41f7-8df1-1fa6f808b2a7","CINSTR-MEDCIGICE-MED" => "5c305c41-1fc5-480f-a5b2-b0ac6acc1e30","CINSTR-MEDCINTSP-MED" => "1e4eeda7-d4ab-4351-90fa-958a608efb10","CINSTR-MEDCISHNP-MED" => "4bc5aa68-57fc-4f34-8687-9a996bbb451a","DATAANAMS" => "dc98b21f-8c3a-4fec-865b-1fc038d1c756","DESIGN" => "3bd07b4f-ccfd-4fbd-b932-74ee962c183d","HOSPDMMC" => "3861fbe9-a424-45c6-90a1-0a55091f590a","DGTLFRN-MS" => "a9aa4a62-d0b2-409b-9ed8-13a11510a477","DIGMED-MA" => "b87171a4-29cb-4c96-a91a-3031fa536f99","DUALLANGGC" => "b949dad9-7e85-43bd-92ac-c2ec7ff76dee","ELRNPRCERT" => "5b237634-a245-4f97-a60c-33cbc2d0a73e","EARLYCH-MS" => "12a74a49-d600-4408-80b0-ab53d9d1b4de","APECO-MAAE" => "e82d8445-ba3b-4f1b-b7ca-079867707dac","EDUCUNDEC" => "d10a3471-5919-4be3-9b84-7d72e83433fe","CURRI-EDSMASTRS30" => "2c049fbc-e8f6-403b-a302-1895cc575217","CURRI-EDSSCHCOUNSEL" => "e142ea0f-05a9-4f7e-948d-8e7e9beac7a1","EDUC-PHDPHD-COUED" => "1c6041e8-71a8-4fb9-836c-3c2f2f755a02","EDUC-PHDPHD-ERLYCH" => "b35d5ef3-fbeb-49e6-88f7-391b980a5ab9","EDUC-PHDPHD-ELEMED" => "094bd6d1-deaf-4cb4-b1e7-e988aa135f27","EDUC-PHDPHD-EXCPED" => "1c82ca6e-65a8-4f19-be5b-f4d6299cab05","EDUC-PHDPHD-EXPHYS" => "709a7567-bb56-454e-a84f-96213856545a","EDUC-PHDPHD-HIGHED" => "c1d95224-21c2-4643-9a33-4ee88a4667ad","EDUC-PHDPHD-INSTEC" => "2ad6981e-0bee-4d8c-b987-3faaf9e48b50","EDUC-PHDPHD-MATHED" => "99b19bdb-707c-4522-95bf-5a9c345a0738","EDUC-PHDPHD-MMA" => "2f9bd1e3-160c-4c79-b979-8023bb1adac6","EDUC-PHDPHD-RDGED" => "f85ad734-3d3c-40c7-88d7-7417f573b418","EDUC-PHDPHD-SCIED" => "5a59d0ee-1853-45e7-886c-a2345128164b","EDUC-PHDPHD-SOCSED" => "20379690-95fa-48f5-8d6f-cfe9bd9b1680","EDUC-PHDPHD-TESOL" => "275476a3-061a-4305-9e3a-728ab12f4a8e","EDLEAD-EDDEXECEDD" => "d14608a2-08b8-4438-8035-b372228aeb4c","EDLEAD-EDDHIGHREDUC" => "5bfabba2-03d3-40a7-ab65-96aefb9e8ae4","EDLEAD-EDS" => "4c85887e-179c-44da-9629-0192ff129403","EDLEAD-MA" => "d6afb814-01df-47d2-a541-33a7a05d668a","EDLEAD-MAHECCEDUC" => "aabe9b3d-9f32-4248-9d75-085bd0e35235","EDLEAD-MAHE-SP LEAD" => "30e5a7bd-761f-4a2e-8b4f-d64b4d98c84d","EDLEAD-MED" => "ea83a5c7-625a-4522-a5a6-78621adb095e","EENGR-MSEE" => "0a982429-a037-4fb0-9240-5e0c4474955a","EENGR-MSEEACCB2MMSEE" => "718983d7-140e-4891-b8ff-8531c2300c2c","EENGR-PHD" => "f7e607dc-4a8b-45a5-9961-95a215d0ec69","ELEMED-MA" => "ae16fb7d-d3ba-40c2-8b14-cfb52b699937","ELEMED-MED" => "851303b4-8e40-4016-be42-ce97f961f300","EMCRMGMECM" => "6c2682ae-1207-40a5-a9e5-b47af2084883","EMGTHMLSEC" => "51923d99-8669-4f36-843e-7ee5359f44e3","CPARTD-MFAANIMVISEFT" => "05fca8b5-3340-42d9-8b1f-95aa2c0fd821","CPARTD-MFAVISLANGSA" => "72f3bb1a-0431-4056-a8f4-c6d69e9950a4","EMGMDA-MFAFEATFLMPRD" => "17d5fb20-166e-46e0-8d10-717936921172","CPARTD-MFASTDARTCOMP" => "d5a1e38a-ec66-4af3-a500-56f46afd26be","ENGRMGT-MSPPSYSTENGR" => "b6c0ae09-5c35-40f9-bcd3-63b4de9aa613","ENGRMGT-MS" => "3cd7cc03-5cbe-4b77-931b-abae38bd5372","ENGLISH-MAENGLIT" => "dba22ad5-020d-410e-b6e8-2e02458510ee","ENGLISH-MATECHWRT" => "ce2ea2f7-c56b-49a2-9167-1d58ac4e8294","ENGLRHC-MARHETORCMP" => "8f98fdeb-75fb-4340-9cba-77b7b611b4c2","ENTRPRNSHP" => "49c20436-1afb-473f-b494-24f69f28cc67","ENVSCI-MSENVSCI" => "c0b2e9d8-e86b-435b-9184-3a8eebd410e6","ENVENGR-MS" => "b8872a03-3c59-4b89-8e0e-c8149adeea61","ENVENG-PHD" => "a6c7c002-a291-42bc-b443-d0a9d0817ab3","TESOLCRT" => "72fdb872-2bb6-444d-b50d-b96e48d3c1a9","THEOAPPETH" => "8ae113d9-107a-42ca-a243-96394e46c242","HOSPEVMANC" => "d6719d55-b2f3-44c9-8ebf-66d641c9a211","EXCHLD-MA" => "32632b5e-fd5e-4913-9707-b84e34842613","EXCHLD-MED" => "84171a74-1241-4585-803f-db0ff8447d6d","DNPFNPC" => "07fb802d-d300-4dff-86fe-27370ad598df","FORSCI-MS" => "342d8963-9327-47a8-ab9f-f4a0cd27c5b9","FNDRSNGCRT" => "5587f661-33ae-4413-8426-00033732ff72","GENDERSTDY" => "d323ac5b-82b3-4b5a-a1d8-2f878d97e9b5","GEOINFOSYS" => "6c5ae3d8-b1c1-41dc-a8b1-aa0df6076297","GIFTEDCERT" => "7c160059-61e6-4353-817e-a18c66122078","GLHPACRT" => "1f0d62b7-1015-4cb6-bbb5-2d664df0ec25","GLBLCOMPED" => "acb26f5e-c2af-4e7e-aa1a-3eb0eedef16b","GRDNONDEG" => "f7ce0d9b-8583-45ab-8e58-dbdf337b2175","HLTHSCI-MSZMRHLEXECH" => "1afe3eb4-8692-4a5b-b0b6-cf0073d5ac26","HLTHSCI-MSHLTHSRVADM" => "97c2735d-0c4f-40d9-ae8f-dedd1ae1c6d9","HLCINFO-MS" => "5c5015c5-366d-4f50-ab4f-d25c4d1fffd5","NURHLCASIM" => "190af6db-262e-4f6f-88f3-d06de3fda8ca","HCIADMCRT" => "4daa3f5d-cf0a-424c-9df9-8a62b9ce9878","HISTORY-MA" => "5acbf7ae-5f87-465d-a17c-13d59401699f","HISTORY-MAHISTORYACC" => "2267bcd7-ae0c-453f-9f50-b20b1bc6e765","HISTORY-MAPUB HIST" => "0b1320b8-b833-4b93-907f-8456e5eff704","HOSPMGT-MS" => "e141a1fd-7c51-4f19-b131-5461d9dd637d","HOSPMGT-MSHSPMS-MD" => "aec3a03b-0a6e-4826-8d38-af1835fa136b","HTTGCERT" => "745f61eb-7cf4-4d04-9687-2a69ee8db4a6","HOSPMGTPHD" => "4ef727eb-b483-4fcf-9bcc-30f493897e8a","HOURESLCRT" => "c65b487d-ea3a-4d46-929f-eb4ff96b5c75","PSYCH-PHDHUMFACT" => "ba0991b9-f156-4f9a-9184-f76ad89dbec7","IORGPSY-MS" => "589f8fbe-b026-4e62-a099-022f4043cd47","PSYCH-PHDINDUSTORG" => "c56df0b1-1d7c-4d37-92c3-9a590b44c3b4","IENGR-MS" => "e26151b5-4f5a-44ab-a101-ea4a52afe542","IENGR-MSZCRHECRSY" => "01037c68-2c55-4d0c-a654-b061d59a797a","IENGR-MSIE" => "378e2c3b-76e1-4504-a467-5f46c793bf50","IENGR-MSIEACCBS2MSIE" => "765e6e8f-3c9c-4db0-9a64-92634883dcb2","IENGR-PHD" => "45f5fd4d-2f04-4ee2-8391-977edef7e119","INTCHPRPCR" => "3918179e-0162-4ec1-a02b-d0c1087f3bd8","ELEARN-MA" => "fff48466-6042-4eda-9f9e-c7dd7a183354","ITSTED-MA" => "4846128f-3521-460a-b73b-21ffe200826d","INSTTEC-MA" => "393d634f-bb57-462b-95a0-e8873b90b125","INSTDESGRC" => "b7dffce1-9157-4db4-867b-fb36f2ede022","INSTDESSIM" => "30411ee0-ab2e-4b62-8212-ca9d71c2446b","INSTEDTCH" => "e8d16599-eb77-4dfd-a487-b799629c71da","INCOBIOPHDCONSERVBIO" => "2012e8f1-3d08-41c9-a1ef-311c060b7989","INCOBIOPHDINTGRTVBIO" => "1ecf1e48-2470-46e0-a05a-a17bad9fd986","INANSCIPHD" => "4544b4cd-0446-4dab-83ee-503f80513c32","PSINATSECC" => "34a4def8-e85e-47d6-bc9b-33bca81dd747","DIGMED-MS" => "eb1b01ed-ca44-440e-bf10-4e18733ba2da","LIBSTDY-MAIDSMA-NTHE" => "1c49df79-20bb-4ad3-84bd-6328841b19d6","LIBSTDY-MAIDSMA-THES" => "30b9f1de-68e4-4c00-8139-0403c9252468","LIBSTDY-MSIDSMS-NTHE" => "733ccce8-019a-47d3-9c19-5cd863f02211","LIBSTDY-MSIDSMS-THES" => "1fc28c1e-d94f-4e32-8c86-ab1e7c40aab3","JUVJUSTLD" => "9bf7e2c0-e982-411b-8ae4-ade66955e18d","K8MATSCIED" => "1fc6e194-cd68-491c-bcef-9cadb835b0b8","K-8MSC-MED" => "529d1138-7fb0-4034-a492-8ca7d19c8279","KINESLGYMS" => "f7935d5d-3c61-485a-a869-e24f3d9c78f1","LDCTEDCERT" => "c0162a0f-30fa-4303-8aec-61bcc99fcbb2","BUS-MSBUSAN-MS" => "b6d62dc1-1fc7-45db-83d8-3e80e614fd52","BUS-MSMRBUSE-MSM" => "315c2bfd-1937-40be-aebd-c6a847078d44","BUS-MSBUSHMRS-MS" => "7cc80b53-dc53-4261-b579-e1b066284b77","BUS-MSBUSITG-MSM" => "b76c6dfd-91d4-4ead-8693-d2c7de4d60d5","MARFAMTHRP" => "60d8ed48-bbdb-46a1-97cc-46f08a8e2205","MARFMTH-MA" => "980f6159-3c51-4c75-a148-fcb0b6841c0b","MATENGR-MS" => "50a91c34-1fe3-45b4-b29d-3030b849c38c","MATENGR-MSACCB2MSMSE" => "837aad9c-0163-43fc-a546-8107d082560a","MATSCI-PHD" => "cba0099b-f0d1-4366-8c7d-d2f3d8bbf407","MATH-MS" => "09248eec-8709-488d-9980-874a1d265779","MATH-MSFINMATHMS" => "76becabf-6476-4dc0-b519-9ae02a6a99b3","MATH-MSINDUSTMATH" => "d1d867fe-fa6e-4005-a297-eb5e739eacde","MATHGRCRT" => "e5a3589d-425a-4941-aacd-57b810863718","MATHSCEDUC" => "d2159879-b726-4e89-8482-6e12db1ee957","MATH-PHD" => "dbbd9581-1cec-4773-adb5-075d53c348e4","MATH-PHDFINMATHPHD" => "3b111ac9-271b-4e7e-a347-b9bf2da6a8d5","MAYASTUDIE" => "c004ed4e-8c73-41e6-a548-9214039443eb","MENGR-MSACCB2MMSME" => "9b44e6c9-91ab-4ebb-8bc0-1b713f33bb60","MENGR-MSMECHSYS" => "fe9da585-6e2f-48ed-bdcb-c6fae9c8129f","MENGR-MSTHERMO" => "91fac7ff-abd3-4142-b84c-8ed74f2a4fe5","MENGR-PHD" => "52101def-23c2-4ffc-8bdf-ac9b47c45c3e","MILSOCWKCR" => "94bb4ac0-4776-4c84-bff4-23eef08691f8","MODSIM-MS" => "c7d26192-396f-4fe0-aabf-de70d96b68be","MODBEHCYBC" => "1626deaa-1580-48f4-a00e-34d397785aaa","MODSMTCSYS" => "27bd9c12-8b1d-4b61-a4a9-39d825357617","MODSMTCSYSGCMODSMIS" => "6cd818dc-5471-4bb1-9412-5496bc971d11","MODSMTCSYSGCMODSMOS" => "b0b2f7aa-cbd7-4e92-b821-fd578e317ae5","MODSM-PHD" => "f9bb440a-4725-4cea-a46f-96a32065b631","MUSIC-MA" => "bb9c1089-542b-494b-b0a1-c0171d613fef","NNOTECH-MS" => "698a6b2e-1970-45c5-b5c9-aaf0727b094f","NNOTECH-MSNTECH-NTHE" => "ae91918e-07e6-4b6f-bad3-546024e2b2a4","NANTECH-MS" => "5496dc01-a707-4668-9a77-f10e09439a18","NONPROFMGM" => "3e9f9495-1299-430a-89da-6cc3b0de2010","NONPROFMGMZCRNONPRFM" => "8342ac48-77c6-4b4e-a8fa-f50737af7876","NONPRFTMNM" => "a5c1c122-b4ac-4224-b586-5f902dd91e66","NONPRFTMNMZCRNONPROS" => "5424bc66-6e0d-4ddb-9916-1167d363ffe8","NONPRFTMNMPUBLADMDD" => "cab69521-f9eb-4894-81c0-50d393a87cbe","NURHLTHPRF" => "45a099d5-5169-45a3-9dbf-b0651dffa3f0","NURS-MSMSN-AGACNP" => "adf3e226-b03e-4292-940f-700dc9d55bca","NURS-MSMSN-A/GNP" => "8b9d5797-862c-4b9d-b9ea-7a22871b0b58","NURS-MSFAMPRACT" => "69ea50d3-955d-4b46-98bd-edbd558811a2","NURS-MSLDRSHPMGMT" => "1e4fbe2f-8356-4131-881a-0d81c5f96441","NURS-MSNURSEDUC" => "01006322-5e6f-48a6-a72f-1b07d6ed04e4","NURS-MSNUHLCASIM" => "83eb991b-bbe3-448b-93f9-93049aa9d041","NURS-PBAC" => "63dcff6f-5382-4b5a-aedf-22c80b6d32f2","NURS-PHD" => "bfde5107-45d3-4007-b333-1f0dd67c6fdb","NURS-PHDNURBSNPHD" => "26ebe00d-29e3-45ec-bb29-ad183dfa6167","NUPRAC-DNPDNP-AGACNP" => "4c64d5c4-b7e8-4f11-9c49-14c0e673dafe","NUPRAC-DNPDNP-A/GNP" => "306ae26d-2de2-4f3a-8e9d-a100e31ccd55","NUPRAC-DNPDNP-ADVPRA" => "ae7c01ec-ea26-4ad4-8034-7e76e7679e51","NUPRAC-DNPDNP-EXEC" => "6ab964b1-1c03-480b-8454-7eaf6c8c5d2e","NUPRAC-DNPDNP-FAMNRS" => "1b9648db-7a29-4b5c-bf76-07385d36b074","OPTIC-MS" => "60efceed-537a-44eb-9915-1bdbf5004ecd","OPTIC-MSOPTIC-OPT" => "ecbe4ed5-edba-49a2-b22e-875c01858e5f","OPTIC-MSOPTIC-PHOT" => "b43151d3-e0bd-4a39-9560-198088695696","OPTIC-PHD" => "6257cccd-bf07-45db-8032-91b655b28150","PT-DPT" => "8814612a-c398-483e-ae98-588be48f11c5","PHYSIC-MS" => "9666c56e-b257-48e3-8c9c-a01fd38741de","PHYSIC-MSPLNETSCIMS" => "027f0b75-8bc7-4c36-8710-050dd014a60d","PHYSIC-PHD" => "5f202aa9-9523-4b0d-b5fe-06852ae02eb7","PHYSIC-PHDPLNETSCIPD" => "1107bf53-c939-4fb9-8e20-ea5a2f905fe2","PLAYTHRPY" => "57e3e2e7-0ce5-4d67-951c-bc3ab7e6c703","POLICELD" => "351eb84f-b640-4b33-8457-f22589316bde","POLISCI-MA" => "b3f9a9bd-5ad7-4942-b84a-ee654c559d66","PKDISABLCR" => "f3f59e65-e9c0-46aa-b6d7-c86e0491de85","PROWRITE" => "37c6f27f-73bd-4086-a7e0-f1446c3b4fd9","PROJENG" => "4c2c6d27-f5ea-422d-a89c-529cb92f8a5b","PUBADMCERT" => "145ac58b-1a76-4f69-a586-49756048163d","PUBADM-MPA" => "f105d135-3ec1-416b-9c6f-d708f07f65b0","PUBADM-MPACRIMJUSDD" => "afc578da-8c62-40c0-8ed0-484bf6a8bc5d","PUBADM-MPANPRFTMGTDD" => "f6871813-512c-4149-ba08-a3b5fe3e26b5","PUBAFF-PHDCRIMJUSPHD" => "7dfee266-f616-4ad1-b6d0-9bd2aefc4092","PUBAFF-PHDGOVPOLPHD" => "0c4ef9e1-00f3-4e45-9104-ff5da8ba6c6a","PUBAFF-PHDHLTHMGTPHD" => "a9f31cde-7314-4c30-bb43-82253893ad06","PUBAFF-PHDPUBADMPHD" => "08b8beed-5032-49d8-a730-194f368b5c46","PUBAFF-PHDPBLADMNDD" => "1d7e268c-92df-431e-bc04-6b93c2144bb3","PUBAFF-PHDSOCWRKPHD" => "c35bd352-babe-4419-9b2c-4a9ea94eaef4","PABUDFINC" => "4f9e7b10-06b1-4ed3-b0aa-ad9b4b56e9e4","PPAGCERT" => "51246b85-5d0d-436a-87fb-d6197e1d0e4d","PUBLPOLMPP" => "5c19860b-7147-4fd3-9dda-039143554eef","PUBLPOLMPP" => "0bf75081-d297-4a4d-a42c-2ff0c786b9fa","QUALASSUR" => "b067f5fd-01c9-4d4d-8af8-15ba53fdd2e2","READEDCRT" => "a037422d-2595-4497-985e-86bf400c5d07","READSP-MED" => "6cbe741b-251f-4bd5-b4d0-d5871f0d0fb9","RLESTAT-MS" => "258aa10a-4b13-4590-a0a3-39c2d314b520","RCHADM-CRT" => "a8534ac3-aea0-4806-a586-550b05584ea1","SASDATA" => "e77c232b-8410-40ae-adf7-14c061c9cd50","SCHPSY-EDS" => "286cb2c4-df66-4df2-a4e1-7fb6e07d5dad","ENGLLA-MEDSEELA-MED" => "b13aa7ce-b565-4731-855f-61b0234b35ce","ENGLLA-MEDSEMATH-MED" => "279a8177-875b-49bb-8041-29c5852d7b69","ENGLLA-MEDSESCI-MED" => "27e919b9-8428-42a5-9a8e-8758ad7b9103","ENGLLA-MEDSESOSC-MED" => "babc81e0-cc47-4873-a47b-1bbb91cc12a3","ENGLLA-MEDSEWLNG-MED" => "27944434-b98d-4e0a-ad7e-f8e016444df5","SCRSTD-PHD" => "5d0d39b9-43c2-4a42-810f-94c1117209de","SVRPFDDISB" => "8f5c12d0-8199-49c4-96a7-e9d71a90c6b9","SOCJUPSCRT" => "80f2b643-84d3-42c2-8af7-47bce8aba222","SOCSCIEDCR" => "a81a3fd7-cfed-4419-ae4e-453d6740bb80","SOCWK-MSWZMRMSWONLP" => "de735c31-1b71-4674-9aab-bed4278f7a75","SOCWK-MSWZMRMSWONAS" => "90e83965-b3df-4416-8ba9-7b05abcb741c","SOCWK-MSWMSW-ORLFT" => "87f84ee9-c9ba-47a2-ac92-ead37cc58c46","SOCWK-MSWMSW-ORFTAS" => "9a01acd7-7f68-4c54-b050-1df0a883679b","SOCWK-MSWMSW-ORLPT" => "ab10f28e-fd31-49f3-aca5-a20c57e07392","SOCWK-MSWMSW-OPTADS" => "8a47a14d-3dc5-438f-a427-f9df16854755","APPSOC-MA" => "7fb98053-5b60-46ce-8425-6f8214d39b2e","APPSOC-MADOMVIO" => "bcc86ed8-9b9b-455c-bfa6-6b17acd13cce","APPSOC-MAMEDSOCLOGY" => "2aeceb34-3647-46a5-b0fd-37cfa292be6b","SOC-PHD" => "276685f0-ef2a-4ff7-b0c4-29f3e15e6e9f","SPANISH-MA" => "a755176c-dc8f-40ee-a2da-d27189b1eb0e","SPECEDCERT" => "7780116a-ccb7-4a7e-a079-d070b649b72d","BUSPMGT-MS" => "137f3880-efd8-4f4f-9c09-b054803a8293","STACOMP-MS" => "1a6212c1-7ee2-4235-9ff3-7b81b66e34dd","STACOMP-MSDATAMINING" => "137b0340-af07-47e5-a290-4e853bcc8332","STRCOMMPHD" => "2e9fc43e-ec7c-48d6-8edc-8013ca8d7ead","CE-SE" => "9cec5979-ff35-499a-8320-63c231f849dd","STUATHSCRT" => "032c8736-7981-426d-8e2c-7b74d02b792c","URBEDUCCRT" => "df809369-facf-47ef-8169-5b3d9f297f87","SYSENGR" => "1fb3a2f3-27dc-4588-9369-9e0387c0d5a5","SYSTENGRMS" => "b770adeb-aef1-44c9-b2ef-8b0d5f3409bb","TCHED-MATART-MAT" => "69e0c9da-91fa-4d54-921e-701c94886f3f","TCHED-MATENGL-MAT" => "5ea402f4-9408-4aa8-9b3c-bbff174287df","TCHED-MATMATH-MAT" => "0007057b-35a7-4cbc-9934-4112dd5693b4","TCHED-MATMATHMS-MAT" => "26cca721-5f89-4760-ae33-85e175106a4a","TCHED-MATSCIMS-MAT" => "96dcb8ca-c56e-49c0-a8f8-d20642b103ec","TCHED-MATSCIBIO-MAT" => "93035b32-ebf9-4abc-95c5-e99317f560d8","TCHED-MATSCICHM-MAT" => "80ffcbe5-7482-4bca-b808-c07a52fa9032","TCHED-MATSCIPHY-MAT" => "1a28620f-7380-472c-b089-b5cbd8a48448","TCHED-MATSOCSCI-MAT" => "16ad7e93-458c-49bd-978c-c4522792c218","TEFLCERT" => "f9e2cf23-501c-4cd1-b974-aa222115002e","TESOL-MA" => "663461f5-234b-4a6e-be27-50de3381cc12","TECHCMRLZN" => "f63c8e31-c27c-4812-aec3-94d96ca017be","TXTTECHPHD" => "d84e1566-d38c-442d-8e70-b4afc113e7ef","THEMA-MA" => "1142101f-f671-42cf-bcc9-011a5edc5711","THEATR-MFAACTING" => "1d904551-c8b7-4f4f-beeb-2be9e0b6a1ac","THEATR-MFAYTHTHRMFA" => "6a6d29d0-1217-47fd-8b81-9acbacc162f1","THEATR-MFATHEMEDEXPR" => "0dee8779-99de-493f-bd71-17ec4fbe184a","TRAINSIM" => "ffebb34e-3c6a-4e46-ae71-979feb88aeea","CE-TRANENG" => "257978ea-6a76-4dfa-b603-3e74cfd70500","TRVLTECHMS" => "4fc55fa5-c31c-4d13-89c2-f62d55fd7960","URB&REG" => "6d6563a6-1367-4a4c-882f-e9d3d15c1c3d","URBREG-MS" => "c23e615b-1286-43e5-9464-52dc71ae501c","WLEESOLCRT" => "29d6459f-bab3-40dc-97fe-9c7fc66afe99","WLELOTECRT" => "3a3d191d-29fd-49dd-9363-e9b46c7d8fc6"
	);
}
?>
