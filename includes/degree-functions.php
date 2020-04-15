<?php
/**
 * Functions specific to degrees
 **/


/**
 *
 * @since 3.3.8
 * @author RJ Bruneel
 *
 */
 function get_degree_content_classic_layout( $post ) {
		$raw_postmeta        = get_post_meta( $post->ID );
		$post_meta           = format_raw_postmeta( $raw_postmeta );
		$program_type        = get_degree_program_type( $post );
		$colleges_list       = get_colleges_markup( $post->ID );
		$departments_list    = get_departments_markup( $post->ID );
		$hide_catalog_desc   = ( isset( $post_meta['degree_disable_catalog_desc'] ) && filter_var( $post_meta['degree_disable_catalog_desc'], FILTER_VALIDATE_BOOLEAN ) === true );

		ob_start();
		?>
		<div class="container mt-4 mb-4 mb-sm-5 pb-md-3">
			<div class="row">
				<div class="col-lg-8 col-xl-7 pr-lg-5 pr-xl-0">
					<div class="bg-faded p-3 p-sm-4 mb-4">
						<dl class="row mb-0">
							<?php if ( $program_type ) : ?>
							<dt class="col-sm-4 col-md-3 col-lg-4 col-xl-3">Program:</dt>
							<dd class="col-sm-8 col-md-9 col-lg-8 col-xl-9"><?php echo $program_type->name; ?></dd>
							<?php endif; ?>
							<?php if ( $colleges_list ) : ?>
							<dt class="col-sm-4 col-md-3 col-lg-4 col-xl-3">College(s):</dt>
							<dd class="col-sm-8 col-md-9 col-lg-8 col-xl-9">
								<?php echo $colleges_list; ?>
							</dd>
							<?php endif; ?>
							<?php if ( $departments_list ) : ?>
							<dt class="col-sm-4 col-md-3 col-lg-4 col-xl-3">Department(s): </dt>
							<dd class="col-sm-8 col-md-9 col-lg-8 col-xl-9">
								<?php echo $departments_list; ?>
							</dd>
							<?php endif; ?>
						</dl>
					</div>
					<div class="hidden-lg-up row mb-3">
						<div class="col-sm mb-2">
							<?php echo get_degree_apply_button( $post ); ?>
						</div>
						<div class="col-sm mb-2">
							<?php echo get_degree_visit_ucf_button(); ?>
						</div>
					</div>
					<div class="mb-3">
						<?php the_content(); ?>
						<?php
						if ( ! $hide_catalog_desc ) {
							echo apply_filters( 'the_content', $post_meta['degree_description'] );
						}
						?>
					</div>
					<div class="row mb-4 mb-lg-5">
					<?php if ( isset( $post_meta['degree_pdf'] ) && ! empty( $post_meta['degree_pdf'] ) ) : ?>
						<div class="col-md-6 col-lg-10 col-xl-6 mb-2 mb-md-0 mb-lg-2 mb-xl-0">
							<a class="btn btn-outline-complementary p-0 h-100 d-flex flex-row justify-content-between" href="<?php echo $post_meta['degree_pdf']; ?>" rel="nofollow">
								<div class="bg-complementary p-3 px-sm-4 d-flex align-items-center"><span class="fa fa-book fa-2x" aria-hidden="true"></span></div>
								<div class="p-3 align-self-center mx-auto">View Catalog</div>
							</a>
						</div>
					<?php endif; ?>
					</div>
					<?php echo main_site_degree_display_subplans( $post->ID ); ?>
				</div>
				<div class="col-lg-4 offset-xl-1 mt-4 mt-lg-0">
					<div class="hidden-md-down mb-5">
						<?php echo get_degree_apply_button( $post ); ?>
						<?php echo get_degree_visit_ucf_button(); ?>
					</div>

					<?php if ( isset( $post_meta['degree_hours'] ) && ! empty( $post_meta['degree_hours'] ) ) : ?>
					<div class="degree-hours mb-5 mt-lg-5">
						<hr>
						<p class="h4 text-center"><?php echo $post_meta['degree_hours']; ?> <span class="font-weight-normal">total credit hours</span></p>
						<hr>
					</div>
					<?php endif; ?>

					<?php echo get_degree_tuition_markup( $post_meta, 'classic' ); ?>

					<?php
					if ( isset( $post_meta['degree_sidebar_content_bottom'] ) && ! empty( $post_meta['degree_sidebar_content_bottom'] ) ) {
						echo apply_filters( 'the_content', $post_meta['degree_sidebar_content_bottom'] );
					}
					?>
				</div>
			</div>
		</div>

		<?php
		return ob_get_clean();
	}



/**
 *
 * @since 3.3.8
 * @author RJ Bruneel
 *
 */
function get_degree_content_modern_layout( $post ) {

	echo get_degree_info_modern_layout( $post );
	echo get_degree_description_modern_layout();
	echo get_degree_application_deadline_modern_layout();
	echo get_degree_course_overview_modern_layout();
	echo get_degree_skills_career_modern_layout();
	echo get_degree_admission_requirements_modern_layout();

}



/**
 *
 * @since 3.3.8
 * @author RJ Bruneel
 *
 */

 function get_degree_info_modern_layout( $post ) {

	$program_type        = get_degree_program_type( $post );
	$raw_postmeta        = get_post_meta( $post->ID );
	$post_meta           = format_raw_postmeta( $raw_postmeta );
	$colleges_list       = get_colleges_markup( $post->ID );
	$departments_list    = get_departments_markup( $post->ID );
	$industry_highlights = get_field('industry_highlights');
	$promo_image         = get_field('promo_image');

	ob_start();
	?>
	<div class="bg-faded">
		<div class="container program-at-a-glance py-lg-3">
			<div class="row my-lg-3">
				<div class="col-lg-3 p-4 pb-3 mt-3 mt-lg-0">

					<h2 class="h5 font-condensed text-uppercase">Program at a Glance</h2>
					<dl class="mt-4 mt-lg-5">
						<?php if ( $program_type ) : ?>
						<dt class="h6 text-uppercase text-default">Program</dt>
						<dd class="h6 mb-4"><?php echo $program_type->name; ?></dd>
						<?php endif; ?>
						<?php if ( $colleges_list ) : ?>
						<dt class="h6 text-uppercase text-default">College(s)</dt>
						<dd class="h6 mb-4"><?php echo $colleges_list; ?></dd>
						<?php endif; ?>
						<?php if ( $departments_list ) : ?>
						<dt class="h6 text-uppercase text-default">Department(s)</dt>
						<dd class="h6"><?php echo $departments_list; ?></dd>
						<?php endif; ?>
					</dl>
				</div>

				<div class="col-lg-2 text-center align-self-center">

					<img class="icon-calendar img-fluid" style="max-height: 4em;" role="img"
						src="https://www.ucf.edu/online/files/2019/12/Calendar-Icon-light-gray.svg" alt="">
					<div class="h1 mt-2 mb-0">16</div>
					<div class="h6 text-muted text-uppercase">Weeks</div>

					<img class="icon-clock img-fluid" style="max-height: 4em;" role="img"
						src="https://www.ucf.edu/online/files/2019/12/Clock-Icon-light-gray.svg" alt="">
					<div class="h1 mt-2 mb-0">44</div>
					<div class="h6 text-muted text-uppercase">Credit Hours</div>

				</div>

				<div class="col-lg-4 bg-secondary text-uppercase border-bottom mb-md-3">
					<?php echo get_degree_tuition_markup( $post_meta, 'modern' ); ?>
				</div>

				<div class="col-lg-3 text-center align-self-center">
					<?php if ( $promo_image ) : ?>
					<img src="<?php echo $promo_image; ?>" class="img-fluid p-4" role="img">
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>

	<?php /* if ( $industry_highlights ) : ?>
	<h2 class="h4 font-condensed text-uppercase">Industry Highlights</h3>
	<?php echo $industry_highlights; ?>
	<?php endif; */ ?>
	<?php
	return ob_get_clean();

 }



 /**
  *
  * @since 3.3.8
  * @author RJ Bruneel
  *
  */
  function get_degree_description_modern_layout() {
	$degree_description_modern_layout = get_field( 'degree_description_modern_layout' );

	if( empty( $degree_description_modern_layout ) ) return '';

	ob_start();
	?>
	<div class="container py-lg-3">
		<div class="row my-lg-3">
			<?php echo $degree_description_modern_layout; ?>
		</div>
	</div>
	<?php

	return ob_get_clean();
  }



  /**
   *
   * @since 3.3.8
   * @author RJ Bruneel
   *
   */
   function get_degree_application_deadline_modern_layout() {
	 $application_deadline_first = get_field( 'application_deadline_first' );
	 $application_deadline_second = get_field( 'application_deadline_second' );

	 if( empty( $application_deadline_first ) && empty( $application_deadline_second ) ) return '';
 
	 ob_start();
	 ?>
	 <div class="bg-default">
		<div class="container py-lg-3">
			<div class="row my-lg-3">
				<div class="col text-center text-uppercase">
					<?php echo $application_deadline_first; ?><br>
					<?php echo $application_deadline_second; ?>
				</div>
			</div>
		</div>
	</div>
	 <?php
 
	 return ob_get_clean();
   }



 /**
  *
  * @since 3.3.8
  * @author RJ Bruneel
  *
  */
  function get_degree_course_overview_modern_layout() {
	$course_overview = get_field( 'course_overview' );

	if( empty( $course_overview ) ) return '';

	ob_start();
	?>
	<div class="bg-faded">
		<div class="container py-lg-3">
			<div class="row my-lg-3">
				<?php echo $course_overview; ?>
			</div>
		</div>
	</div>
	<?php

	return ob_get_clean();
  }



/**
 *
 * @since 3.3.8
 * @author RJ Bruneel
 *
 */
 function get_degree_skills_career_modern_layout() {
	$skills_heading = get_field( 'skills_heading' );
	$skills_content = get_field( 'skills_content' );
	$careers_heading = get_field( 'careers_heading' );
	$careers_content = get_field( 'careers_content' );

	if( empty( $skills_content ) && empty( $careers_content ) ) return '';

	ob_start();
	?>
	<div class="bg-inverse">
		<div class="container">
			<div class="row py-lg-5">
				<div class="col-12">
					<?php if( $skills_heading ) : ?>
						<h2 class="font-condensed text-primary text-uppercase mb-4"><?php echo $skills_heading; ?></h2>
					<?php endif; ?>
				</div>
				<div class="col-lg-8 py-lg-3">
					<?php if( $skills_content ) : ?>
						<?php echo $skills_content; ?>
					<?php endif; ?>
				</div>
				<div class="col-lg-4">
					<?php if( $careers_heading ) : ?>
						<h3 class="font-condensed h5 text-uppercase mb-3"><?php echo $careers_heading; ?></h2>
					<?php endif; ?>
					<?php if( $careers_content ) : ?>
						<?php echo $careers_content; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<?php

	return ob_get_clean();
 }



/**
 *
 * @since 3.3.8
 * @author RJ Bruneel
 *
 */
function get_degree_admission_requirements_modern_layout() {
	$admission_requirements = get_field( 'admission_requirements' );

	if( empty( $admission_requirements ) ) return '';

	ob_start();
	?>
	<div class="bg-faded">
		<div class="container py-lg-3">
			<div class="row my-lg-3">
				<?php echo $admission_requirements; ?>
			</div>
		</div>
	</div>

	<?php

	return ob_get_clean();
}

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

function get_degree_tuition_markup( $post_meta, $type ) {
	$resident = isset( $post_meta['degree_resident_tuition'] ) ? $post_meta['degree_resident_tuition'] : null;
	$nonresident = isset( $post_meta['degree_nonresident_tuition'] ) ? $post_meta['degree_nonresident_tuition'] : null;
	$skip = ( isset( $post_meta['degree_tuition_skip'] ) && $post_meta['degree_tuition_skip'] === 'on' ) ? true : false;

	if ( $resident && $nonresident && ! $skip ) {
		if( $type === 'modern' ) {
			return ucf_tuition_fees_degree_modern_layout( $resident, $nonresident );
		} else {
			return ucf_tuition_fees_degree_classic_layout( $resident, $nonresident );
		}
	}

	return '';
}

function ucf_tuition_fees_degree_classic_layout( $resident, $nonresident ) {
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


function ucf_tuition_fees_degree_modern_layout( $resident, $nonresident ) {
	$value_message = get_theme_mod( 'tuition_value_message', null );
	$disclaimer = get_theme_mod( 'tuition_disclaimer', null );

	ob_start();
?>
	<ul class="nav nav-tabs pt-3" role="tablist">
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
			<?php endif; ?>
			<div class="p-4">
				<p class="h1 text-center font-weight-bold mb-0">
					<?php echo $resident; ?>
				</p>
			<?php if ( $disclaimer ) : ?>
				<p class="mt-3 mb-0"><small><?php echo $disclaimer; ?></small></p>
			<?php endif; ?>
			</div>
		</div>
		<div class="tab-pane" id="out-of-state" role="tabpanel">
			<?php if ( $value_message ) : ?>
			<?php endif; ?>
			<div class="p-4">
				<p class="h1 text-center font-weight-bold mb-0">
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
