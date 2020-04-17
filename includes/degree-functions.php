<?php
/**
 * Functions specific to degrees
 **/


/**
  * Returns HTML for the classic degree layout.
  *
  * @since 3.4.0
  * @author RJ Bruneel
  * @param object $post  WP_Post object
  * @return string HTML markup
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
 * Returns HTML for the modern degree layout.
 *
 * @since 3.4.0
 * @author RJ Bruneel
 * @param object $post WP_Post object
 * @return string HTML markup
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
 * Returns HTML for the degree info section.
 *
 * @since 3.4.0
 * @author RJ Bruneel
 * @param object $post WP_Post object
 * @return string HTML markup
 *
 */

 function get_degree_info_modern_layout( $post ) {

	$program_type        = get_degree_program_type( $post );
	$raw_postmeta        = get_post_meta( $post->ID );
	$post_meta           = format_raw_postmeta( $raw_postmeta );
	$colleges_list       = get_colleges_markup( $post->ID );
	$departments_list    = get_departments_markup( $post->ID );
	$promo_image         = get_field('promo_image');
	$promo_image_alt     = get_field('promo_image_alt');

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
					<?php echo get_field('program_length'); ?>
				</div>

				<div class="col-lg-4 bg-faded text-uppercase border-bottom mb-md-3">
					<?php echo get_degree_tuition_markup( $post_meta, 'modern' ); ?>
				</div>

				<?php if ( $promo_image ) : ?>
					<div class="col-lg-3 text-center align-self-center">
						<img src="<?php echo $promo_image; ?>" class="img-fluid p-4" role="img" alt="<?php echo $promo_image_alt; ?>">
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>

	<?php
	return ob_get_clean();

 }



 /**
 * Returns HTML for the degree description section.
  *
  * @since 3.4.0
  * @author RJ Bruneel
  * @return string HTML markup
  *
  */
  function get_degree_description_modern_layout() {
	$degree_description_modern_layout = get_field( 'degree_description_modern_layout' );

	if( empty( $degree_description_modern_layout ) ) return '';

	ob_start();
	?>
	<div class="container py-lg-3">
		<div class="row my-lg-3">
			<div class="col-12">
				<?php echo $degree_description_modern_layout; ?>
			</div>
		</div>
	</div>
	<?php

	return ob_get_clean();
  }



  /**
   * Returns HTML for the application deadline section.
   *
   * @since 3.4.0
   * @author RJ Bruneel
   * @return string HTML markup
   *
   */
   function get_degree_application_deadline_modern_layout() {
		$application_deadline_first = get_field( 'application_deadline_first' );
		$application_deadline_second = get_field( 'application_deadline_second' );

		if( empty( $application_deadline_first ) && empty( $application_deadline_second ) ) return '';

		ob_start();
		?>
		<section aria-label="Application Deadline">
			<div class=" d-block d-lg-none">
				<div class="bg-primary text-center pt-5">
					<h2 class="h4 text-uppercase font-condensed my-0">Application Deadline</h2>
				</div>
			<?php if( $application_deadline_first ) : ?>
				<div class="text-uppercase text-center bg-primary py-4">
					<?php echo $application_deadline_first; ?>
				</div>
			<?php endif; ?>
			<?php if( $application_deadline_second ) : ?>
				<div class="bg-primary py-1">
					<hr class="hr-white hr-2 my-0 mx-5 application-deadline-hr">
				</div>
				<div class="text-uppercase text-center bg-primary py-4 bg-arrow-down">
					<div class="pb-5">
						<?php echo $application_deadline_second; ?>
					</div>
				</div>
			<?php endif; ?>
				<div class="modern-degree-dark-grey text-white py-4 text-center">
					<h2 class="h5 text-uppercase font-condensed mt-3">Ready to<br>get started?</h2>
				</div>
				<div class="col pt-1 pb-5 text-uppercase modern-degree-dark-grey text-center">
					<a id="CTA" class="btn btn-lg btn-primary rounded" rel="noopener noreferrer" data-toggle="modal" data-target="#formModal">Apply Now</a>
				</div>
			</div>

			<div class="container-fluid px-0 d-none d-lg-block">
				<div class="row no-gutters">
					<div class="col bg-primary">
					</div>
					<div class="col bg-primary">
						<div class="container bg-primary">
							<div class="row">
								<div class="col-auto py-4 bg-primary align-self-center">
									<h2 class="h5 text-uppercase font-condensed mb-0">Application<br>Deadline</h2>
								</div>
							<?php if( $application_deadline_first ) : ?>
								<div class="col py-4 text-uppercase text-center bg-primary align-self-center">
									<?php echo $application_deadline_first; ?>
								</div>
							<?php endif; ?>
							<?php if( $application_deadline_second ) : ?>
								<div class="col-auto py-4 bg-primary">
									<hr class="hr-white hr-vertical hr-2 mx-0">
								</div>
								<div class="col py-4 text-uppercase text-center bg-primary align-self-center">
									<?php echo $application_deadline_second; ?>
								</div>
							<?php endif; ?>
								<div class="col-auto px-0">
									<div class="triangle"></div>
								</div>
								<div class="col-auto py-4 modern-degree-dark-grey text-white">
									<div class="h-100 d-flex align-items-center">
										<h2 class="h5 text-uppercase font-condensed mb-0 ml-4">Ready to<br>get started?</h2>
									</div>
								</div>
								<div class="col-auto py-4 text-uppercase modern-degree-dark-grey">
									<div class="h-100 d-flex align-items-center">
										<a id="CTA" class="btn btn-lg btn-primary rounded mt-1" rel="noopener noreferrer" data-toggle="modal" data-target="#formModal">Apply Now</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col modern-degree-dark-grey">
					</div>
				</div>
			</div>
		</section>
		<?php
 
		return ob_get_clean();
   }



 /**
  * Returns HTML for the course overview section.
  *
  * @since 3.4.0
  * @author RJ Bruneel
  * @return string HTML markup
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
				<div class="col-12">
					<?php echo $course_overview; ?>
				</div>
			</div>
		</div>
	</div>
	<?php

	return ob_get_clean();
  }



/**
  * Returns HTML for the degree skills and careers section.
  *
  * @since 3.4.0
  * @author RJ Bruneel
  * @return string HTML markup
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
				<?php if( $skills_heading ) : ?>
					<div class="col-12">
						<h2 class="font-condensed text-primary text-uppercase mb-4"><?php echo $skills_heading; ?></h2>
					</div>
				<?php endif; ?>

				<?php if( $skills_content ) : ?>
					<div class="col-lg-8 py-lg-3">
						<?php echo $skills_content; ?>
					</div>
				<?php endif; ?>

				<?php if( $careers_heading || $careers_content ) : ?>
					<div class="col-lg-4">
						<?php if( $careers_heading ) : ?>
							<h3 class="font-condensed h5 text-uppercase mb-3"><?php echo $careers_heading; ?></h2>
						<?php endif; ?>
						<?php if( $careers_content ) : ?>
							<?php echo $careers_content; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php

	return ob_get_clean();
 }



/**
  * Returns HTML for the admissions requirements section.
  *
  * @since 3.4.0
  * @author RJ Bruneel
  * @return string HTML markup
  *
  */
function get_degree_admission_requirements_modern_layout() {
	$admission_copy = get_field( 'admission_copy' );
	$admission_list = get_field( 'admission_list' );

	if( empty( $admission_copy ) && empty( $admission_list ) ) return '';

	ob_start();
	?>
	<div class="bg-faded">
		<div class="container py-lg-3">
			<div class="row my-lg-3">
				<div class="col-12">
					<h2 class="font-condensed text-uppercase mb-4">Admission Requirements</h2>
				</div>
				<?php if( $admission_copy ) : ?>
				<div class="col-6">
					<p><?php echo $admission_copy; ?></p>
					<?php // TODO update link href ?>
					<a class="btn btn-primary" href="#">
						Request Information
					</a>
				</div>
				<?php endif; ?>
				<?php if( $admission_list ) : ?>
				<div class="col-6">
					<div class="py-3 px-4 bg-secondary">
						<?php echo $admission_list; ?>
					</div>
				</div>
				<?php endif; ?>
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
	$disclaimer = get_theme_mod( 'tuition_disclaimer', null );
	$format_label = '<div class="text-uppercase text-center font-weight-bold mt-2">per credit hour</div>';

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

	<div class="tuition-fees-tab-content tab-content pt-4 bg-secondary">
		<div class="tab-pane active" id="in-state" role="tabpanel">
			<div class="p-4">
				<p class="h1 text-center font-weight-bold mb-0">
					<?php echo str_replace( "per credit hour", $format_label, $resident ); ?>
				</p>
			<?php if ( $disclaimer ) : ?>
				<p class="mt-3 mb-0"><small><?php echo $disclaimer; ?></small></p>
			<?php endif; ?>
			</div>
		</div>
		<div class="tab-pane" id="out-of-state" role="tabpanel">
			<div class="p-4">
				<p class="h1 text-center font-weight-bold mb-0">
					<?php echo str_replace( "per credit hour", $format_label, $nonresident ); ?>
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
 * Helper function for getting remote json
 * @author Jim Barnes
 * @since 3.4.0
 * @param string $url The URL to retrieve
 * @param object The serialized JSON obejct
 */
function main_site_get_remote_response_json( $url, $default=null ) {
	$args = array(
		'timeout' => 5
	);

	$retval = $default;
	$response = wp_remote_get( $url, $args );

	if ( is_array( $response ) && wp_remote_retrieve_response_code( $response ) < 400 ) {
		$retval = json_decode( wp_remote_retrieve_body( $response ) );
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

	$outcomes    = main_site_get_remote_response_json( $program->outcomes );
	$projections = main_site_get_remote_response_json( $program->projection_totals );

	$meta['degree_avg_annual_earnings'] = isset( $outcomes->latest->avg_annual_earnings ) ?
		$outcomes->latest->avg_annual_earnings :
		null;

	$meta['degree_employed_full_time'] = isset( $outcomes->latest->employed_full_time ) ?
		$outcomes->latest->employed_full_time :
		null;

	$meta['degree_continuing_education'] = isset( $outcomes->latest->continuing_education ) ?
		$outcomes->latest->continuing_education :
		null;

	$meta['degree_outcome_academic_year'] = isset( $outcomes->latest->academic_year_display ) ?
		$outcomes->latest->academic_year_display :
		null;

	$meta['degree_prj_begin_year'] = isset( $projections->begin_year ) ?
		$projections->begin_year :
		null;

	$meta['degree_prj_end_year'] = isset( $projections->end_year ) ?
		$projections->end_year :
		null;

	$meta['degree_prj_begin_employment'] = isset( $projections->begin_employment ) ?
		$projections->begin_employment :
		null;

	$meta['degree_prj_end_employment'] = isset( $projections->end_employment ) ?
		$projections->end_employment :
		null;

	$meta['degree_prj_change'] = isset( $projections->change ) ?
		$projections->change :
		null;

	$meta['degree_prj_change_percentage'] = isset( $projections->change_percentage ) ?
		$projections->change_percentage :
		null;

	$meta['degree_prj_openings'] = isset( $projections->openings ) ?
		$projections->openings :
		null;

	return $meta;
}

add_filter( 'ucf_degree_get_post_metadata', 'mainsite_degree_format_post_data', 10, 2 );

/**
 * Adds career paths from the career data within the program
 * @author Jim Barnes
 * @since 3.4.0
 * @param array $terms The array of terms to return
 * @param object The program object from the search service
 * @return array
 */
function mainsite_degree_get_post_terms( $terms, $program ) {
	$careers = main_site_get_remote_response_json( $program->careers, array() );

	$terms['career_paths'] = $careers;

	return $terms;
}

add_filter( 'ucf_degree_get_post_terms', 'mainsite_degree_get_post_terms', 10, 2 );

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
