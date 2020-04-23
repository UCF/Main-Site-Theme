<?php
/**
 * Functions specific to degrees
 **/


/**
  * Returns HTML for the classic degree layout.
  *
  * @since 3.4.0
  * @author RJ Bruneel
  * @param object $degree  WP_Post object
  * @return string HTML markup
  */
 function get_degree_content_classic_layout( $degree ) {
	$raw_postmeta        = get_post_meta( $degree->ID );
	$post_meta           = format_raw_postmeta( $raw_postmeta );
	$program_type        = get_degree_program_type( $degree );
	$colleges_list       = get_colleges_markup( $degree->ID );
	$departments_list    = get_departments_markup( $degree->ID );
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
						<?php echo get_degree_apply_button( $degree ); ?>
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
				<?php echo main_site_degree_display_subplans( $degree->ID ); ?>
			</div>
			<div class="col-lg-4 offset-xl-1 mt-4 mt-lg-0">
				<div class="hidden-md-down mb-5">
					<?php echo get_degree_apply_button( $degree ); ?>
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
 * @param object $degree WP_Post object representing a degree
 * @return string HTML markup
 *
 */
function get_degree_content_modern_layout( $degree ) {
	echo get_degree_info_modern_layout( $degree );
	echo get_degree_description_modern_layout( $degree );
	echo get_degree_application_deadline_modern_layout( $degree );
	echo get_degree_course_overview_modern_layout( $degree );
	echo get_degree_quotes_modern_layout( $degree );
	echo get_degree_skills_career_modern_layout( $degree );
	echo get_degree_admission_requirements_modern_layout( $degree );
	echo get_degree_news_spotlight_modern_layout( $degree );
}


/**
 * Filter that sets header contents for degrees.
 *
 * @author Jo Dickson
 * @since 3.4.0
 * @param string $markup The passed in markup
 * @param mixed $obj The post/term object, or null
 * @return string The header markup
 */
function get_header_content_degree( $markup, $obj ) {
	if ( isset( $obj->post_type ) && $obj->post_type === 'degree' ) {
		$title                        = get_header_title( $obj );
		$subtitle                     = get_header_subtitle( $obj );
		$h1                           = get_header_h1_option( $obj );
		$title_elem                   = ( $h1 === 'title' ) ? 'h1' : 'span';
		$subtitle_elem                = ( $h1 === 'subtitle' ) ? 'h1' : 'span';
		$degree_template              = get_page_template_slug( $obj );
		$show_degree_request_info_btn = false;
		$header_content_col_classes   = 'header-degree-content-col col-sm-auto d-sm-flex align-items-sm-center';

		if ( $degree_template === 'template-degree-modern.php' ) {
			$header_content_col_classes .= ' ml-sm-auto';
			$show_degree_request_info_btn = true;
		}

		ob_start();

		if ( $title ):
?>
		<div class="header-content-inner">
			<div class="container px-0 h-100">
				<div class="row no-gutters h-100">
					<div class="<?php echo $header_content_col_classes; ?>">
						<div class="header-degree-content-bg bg-primary-t-2 p-3 p-sm-4 mb-sm-5">
							<<?php echo $title_elem; ?> class="header-title header-title-degree"><?php echo $title; ?></<?php echo $title_elem; ?>>

							<?php if ( $subtitle ) : ?>
								<<?php echo $subtitle_elem; ?> class="header-subtitle header-subtitle-degree"><?php echo $subtitle; ?></<?php echo $subtitle_elem; ?>>
							<?php endif; ?>

							<?php
							if ( $show_degree_request_info_btn ) {
								echo get_degree_request_info_button(
									$obj,
									'header-degree-cta btn btn-secondary text-primary hover-text-white d-flex align-items-center my-2 mx-auto mx-sm-2 px-5 py-3',
									'mr-3 fa fa-info-circle fa-2x',
									'Request Info'
								);
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
		endif;

		$markup = ob_get_clean();

	}

	return $markup;
}

add_filter( 'get_header_content_title_subtitle', 'get_header_content_degree', 10, 2 );


/**
 * Returns HTML for the degree info section.
 *
 * @since 3.4.0
 * @author RJ Bruneel
 * @param object $degree WP_Post object representing a degree
 * @return string HTML markup
 */
function get_degree_info_modern_layout( $degree ) {
	$program_type        = get_degree_program_type( $degree );
	$raw_postmeta        = get_post_meta( $degree->ID );
	$post_meta           = format_raw_postmeta( $raw_postmeta );
	$colleges_list       = get_colleges_markup( $degree->ID );
	$departments_list    = get_departments_markup( $degree->ID );
	$program_length      = get_field( 'program_length', $degree );
	$tuition             = get_degree_tuition_markup( $post_meta, 'modern' );
	$promo_image         = get_field( 'promo_image', $degree );
	$promo_image_alt     = get_field( 'promo_image_alt', $degree );

	ob_start();
	?>
	<section aria-label="Program at a glance">
		<div class="jumbotron bg-faded pb-4 pb-md-5">
			<div class="container">
				<div class="row d-lg-flex justify-content-lg-between">
					<div class="col col-lg-5 pr-lg-5">
						<h2 class="h4 font-condensed text-uppercase mb-4 pb-2">Program at a Glance</h2>
						<div class="row">
							<div class="col col-sm-9 col-lg mb-4 mb-lg-0">
								<dl>
									<?php if ( $program_type ) : ?>
									<dt class="h6 text-uppercase text-default">Program</dt>
									<dd class="h5 mb-4"><?php echo $program_type->name; ?></dd>
									<?php endif; ?>

									<?php if ( $colleges_list ) : ?>
									<dt class="h6 text-uppercase text-default">College(s)</dt>
									<dd class="h5 mb-4"><?php echo $colleges_list; ?></dd>
									<?php endif; ?>

									<?php if ( $departments_list ) : ?>
									<dt class="h6 text-uppercase text-default">Department(s)</dt>
									<dd class="h5"><?php echo $departments_list; ?></dd>
									<?php endif; ?>
								</dl>
							</div>
							<?php if ( $program_length ): ?>
							<div class="col-auto pr-5 pr-sm-3 mb-4 mb-lg-0">
								<?php echo $program_length; ?>
							</div>
							<?php endif; ?>
						</div>
					</div>

					<div class="w-100 hidden-sm-down hidden-lg-up"></div>

					<?php if ( $tuition ): ?>
					<div class="col-md-7 col-lg mb-4 mb-lg-0 pr-lg-4 pr-xl-3">
						<?php echo $tuition; ?>
					</div>
					<?php endif; ?>

					<?php if ( $promo_image ) : ?>
					<div class="col-md-5 col-lg-2 col-xl-3 mb-4 mb-lg-0 text-center d-flex align-items-center">
						<div class="row no-gutters w-100">
							<div class="col-6 offset-3 col-sm-4 offset-sm-4 col-md-8 offset-md-2 col-lg-12 offset-lg-0 col-xl-10 offset-xl-1">
								<img src="<?php echo $promo_image; ?>" class="img-fluid" alt="<?php echo $promo_image_alt; ?>">
							</div>
						</div>
					</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</section>

	<?php
	return ob_get_clean();

}


/**
 * Returns HTML for the degree description section.
 *
 * @since 3.4.0
 * @author RJ Bruneel
 * @param object $degree WP_Post object representing a degree
 * @return string HTML markup
 */
function get_degree_description_modern_layout( $degree ) {
	$modern_description_heading = get_field( 'modern_description_heading', $degree );
	$modern_description_copy = get_field( 'modern_description_copy', $degree );
	$modern_description_image = get_field( 'modern_description_image', $degree );
	$modern_description_image_alt = get_field( 'modern_description_image_alt', $degree );

	if( empty( $modern_description_heading ) && empty( $modern_description_copy ) ) return '';

	ob_start();
?>
	<section aria-label="Program description and highlights">
		<div class="container py-lg-3 my-5">
			<div class="row my-lg-3">
				<div class="col">
					<?php if( $modern_description_heading ) : ?>
						<h2 class="font-weight-light mb-4 pb-2">
							<?php echo $modern_description_heading; ?>
						</h2>
					<?php endif; ?>

					<?php if( $modern_description_copy ) : ?>
						<?php echo $modern_description_copy; ?>
					<?php endif; ?>

					<?php
					echo get_degree_request_info_button(
						$degree,
						'btn btn-complementary mt-3',
						'',
						'Request Information'
					);
					?>
				</div>

				<?php if ( $modern_description_image || ( have_rows( 'highlights', $degree ) ) ): ?>
				<div class="col-lg-6 pl-lg-5 mt-5 mt-lg-0">
					<?php if ( $modern_description_image ) : ?>
						<div class="px-5 px-lg-0">
							<img src="<?php echo $modern_description_image; ?>" class="img-fluid mb-5" alt="<?php echo $modern_description_image_alt; ?>">
						</div>
					<?php endif; ?>

					<?php if ( have_rows( 'highlights', $degree ) ) : ?>
						<h3 class="heading-underline mb-4 pb-2">Highlights</h3>
						<?php while( have_rows( 'highlights', $degree ) ): the_row(); ?>
							<div class="row mb-4">
								<div class="col-3 text-center">
									<img src="<?php the_sub_field( 'highlight_image' ); ?>" class="img-fluid" alt="">
								</div>
								<div class="col-9 align-self-center">
									<?php the_sub_field( 'highlight_copy' ); ?>
								</div>
							</div>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php

	return ob_get_clean();
}


/**
 * Returns HTML for the application deadline section.
 *
 * @since 3.4.0
 * @author RJ Bruneel
 * @param object $degree WP_Post object representing a degree
 * @return string HTML markup
 */
function get_degree_application_deadline_modern_layout( $degree ) {
	$deadlines = get_field( 'application_deadlines', $degree );
	$deadlines_count = is_array( $deadlines ) ? count( $deadlines ) : 0;

	ob_start();

	if ( $deadlines_count ):
		$deadline_heading_col_class = 'col-lg-4';
		$deadlines_col_class = 'col-lg-8 pl-lg-5 pr-xl-5';
		if ( $deadlines_count === 1 ) {
			$deadline_heading_col_class = 'col-lg-7 pr-lg-3';
			$deadlines_col_class = 'col-lg-5 pl-lg-5';
		}
		else if ( $deadlines_count > 2 ) {
			$deadline_heading_col_class = 'mb-4';
			$deadlines_col_class = 'pr-lg-5';
		}
?>
		<section aria-label="Application Deadline">
			<div class="degree-deadline-wrap">
				<div class="degree-deadline-row">
					<!-- Left-hand surrounding pad, for desktop -->
					<div class="degree-deadline-pad bg-primary"></div>

					<!-- Inner content -->
					<div class="degree-deadline-content degree-deadline-content-deadlines text-center text-lg-left">
						<div class="row no-gutters w-100 h-100 d-lg-flex align-items-lg-center">
							<div class="col-12 <?php echo $deadline_heading_col_class; ?>">
								<h2 class="h4 text-uppercase font-condensed mb-4 mb-md-5 mb-lg-0">
									Application Deadline
								</h2>
							</div>
							<div class="col-12 <?php echo $deadlines_col_class; ?>">
								<div class="row d-lg-flex justify-content-lg-between">
								<?php while ( have_rows( 'application_deadlines', $degree ) ) : the_row(); ?>

									<div class="col-lg-auto my-lg-3 text-center text-uppercase">
										<h3 class="h5">
											<?php the_sub_field( 'deadline_term' ); ?>
										</h3>
										<p class="mb-0">
											<?php the_sub_field( 'deadline' ); ?>
										</p>
									</div>

									<?php if ( get_row_index() < $deadlines_count ): ?>
									<div class="col-12 col-lg-auto">
										<div class="hidden-lg-up">
											<hr class="hr-2 hr-white w-50 my-4" role="presentational">
										</div>
										<div class="hidden-md-down h-100">
											<hr class="hr-2 hr-white hr-vertical mx-0" role="presentational">
										</div>
									</div>
									<?php endif; ?>

								<?php endwhile; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="degree-deadline-content degree-deadline-content-start text-center text-lg-left bg-gray-darker">
						<div class="row no-gutters d-lg-flex justify-content-lg-center align-self-lg-center">
							<div class="col-12 col-lg-auto pr-xl-4">
								<h2 class="h5 text-uppercase font-condensed mb-4 mb-lg-3 mb-xl-0">
									<span class="d-xl-block">Ready to</span>
									<span class="d-xl-block">get started?</span>
								</h2>
							</div>
							<div class="col-12 col-lg-auto">
								<?php
								echo get_degree_apply_button(
									$degree,
									'btn btn-lg btn-primary rounded',
									'',
									'Apply Today'
								);
								?>
							</div>
						</div>
					</div>

					<!-- Right-hand surrounding pad, for desktop -->
					<div class="degree-deadline-pad bg-gray-darker"></div>
				</div>
			</div>
		</section>
<?php
	endif;

	return ob_get_clean();
}


/**
 * Returns HTML for the course overview section.
 *
 * @since 3.4.0
 * @author RJ Bruneel
 * @param object $degree WP_Post object representing a degree
 * @return string HTML markup
 */
function get_degree_course_overview_modern_layout( $degree ) {
	$course_overview = get_field( 'course_overview', $degree );

	if ( empty( $course_overview ) ) return '';

	ob_start();

	if ( have_rows( 'course_overview', $degree ) ) : ?>
		<div class="py-4">
			<div class="container py-lg-3">
				<div class="row my-lg-3">
					<div class="col-12">
						<h2 class="font-condensed text-uppercase mb-4">Course Overview</h2>
						<div class="accordion" role="tablist" id="courses">
							<?php while ( have_rows( 'course_overview', $degree ) ) : the_row(); ?>
								<div class="accordion-courses mt-0 pt-0 pt-lg-3">
									<h3 class="mb-0">
										<a data-toggle="collapse" data-target="#course-<?php echo get_row_index(); ?>" aria-controls="course-<?php echo get_row_index(); ?>" role="button" tabindex="0" aria-expanded="true">
											<span class="font-condensed h6 letter-spacing-2 mb-3 text-uppercase">
												<?php the_sub_field( 'course_title' ); ?>
											</span>
											<span class="fa pull-right text-inverse-aw fa-minus-circle" aria-hidden="true"></span>
										</a>
									</h3>
									<div class="collapse<?php if ( get_row_index() === 1 ) echo " show" ?>" id="course-<?php echo get_row_index(); ?>" data-parent="#courses" role="tabpanel" aria-expanded="true">
										<p class="mt-3 mb-0"><?php the_sub_field( 'course_description' ); ?></p>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif;

	return ob_get_clean();
}


/**
 * Returns HTML for the quotes section.
 *
 * @since 3.4.0
 * @author RJ Bruneel
 * @param object $degree WP_Post object representing a degree
 * @return string HTML markup
 */
function get_degree_quotes_modern_layout( $degree ) {
	$course_overview = get_field( 'course_overview', $degree );

	if ( empty( $course_overview ) ) return '';

	ob_start();

	if ( have_rows( 'degree_quotes', $degree ) ) : ?>
		<div class="bg-faded">
			<div class="container pt-5">
				<?php while ( have_rows( 'degree_quotes', $degree ) ) : the_row(); ?>
					<div class="row pb-5">
						<?php if( get_sub_field( 'degree_quote_image' ) ) : ?>
							<div class="col-lg-3 text-center text-lg-right align-self-center">
								<img src="<?php the_sub_field( 'degree_quote_image' ); ?>" class="img-fluid"
									alt="<?php the_sub_field( 'degree_quote_image_alt' ); ?>">
							</div>
						<?php endif; ?>
						<?php $quote_col_class = ( get_sub_field( 'degree_quote_image' ) ) ? "col-lg-9" : "col-12 col-xl-10 offset-xl-1"; ?>
						<div class="<?php echo $quote_col_class; ?>">
							<blockquote class="blockquote blockquote-quotation">
								<p class="mb-0"><?php the_sub_field( 'degree_quote' ); ?></p>
								<footer class="blockquote-footer"><?php the_sub_field( 'degree_quote_footer' ); ?></footer>
							</blockquote>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>

	<?php endif;

	return ob_get_clean();
}


/**
 * Returns HTML for the degree skills and careers section.
 *
 * @since 3.4.0
 * @author RJ Bruneel
 * @param object $degree WP_Post object representing a degree
 * @return string HTML markup
 */
function get_degree_skills_career_modern_layout( $degree ) {
	$degree_skills_heading = get_field( 'degree_skills_heading', $degree );
	$degree_careers_heading = get_field( 'degree_careers_heading', $degree );

	if ( empty( $degree_skills_heading ) && empty( $degree_careers_heading ) ) return '';

	ob_start();
	?>
	<div class="bg-inverse">
		<div class="container">
			<div class="row py-5">
				<?php if( $degree_skills_heading ) : ?>
					<div class="col-12">
						<h2 class="font-condensed text-primary text-uppercase my-4"><?php echo $degree_skills_heading; ?></h2>
					</div>
				<?php endif; ?>

				<?php if( have_rows( 'degree_skills_list', $degree ) ) : ?>
					<div class="col-lg-7 py-lg-3">
						<ul class="pl-4 mb-0">
							<?php while ( have_rows( 'degree_skills_list', $degree ) ) : the_row(); ?>
								<?php if( get_sub_field( 'degree_skills_list_item' ) ) : ?>
									<li class="degree-skill-list-item mb-4">
										<?php the_sub_field( 'degree_skills_list_item' ); ?>
									</li>
								<?php endif; ?>
							<?php endwhile; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php if( $degree_careers_heading ) : ?>
					<div class="col-lg-4 offset-lg-1 mt-4">
						<?php if( $degree_careers_heading ) : ?>
							<h3 class="font-condensed h5 text-uppercase mb-3"><?php echo $degree_careers_heading; ?></h2>
						<?php endif; ?>

						<?php if( have_rows( 'degree_career_list', $degree ) ) : ?>
							<div class="col-lg-8 py-lg-3">
								<ul class="degree-career-list pl-2">
									<?php while ( have_rows( 'degree_career_list', $degree ) ) : the_row(); ?>
										<?php if( get_sub_field( 'degree_career_list_item' ) ) : ?>
											<li class="degree-career-list-item">
												<?php the_sub_field( 'degree_career_list_item' ); ?>
											</li>
										<?php endif; ?>
									<?php endwhile; ?>
								</ul>
							</div>
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
  * @param object $degree WP_Post object representing a degree
  * @return string HTML markup
  */
function get_degree_admission_requirements_modern_layout( $degree ) {
	$admission_copy = get_field( 'admission_copy', $degree );
	$admission_list = get_field( 'admission_list', $degree );

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
					<?php echo $admission_copy; ?>
					<?php echo get_degree_request_info_button( $degree ); ?>
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
  * Returns HTML for the news and spotlight section.
  *
  * @since 3.4.0
  * @author RJ Bruneel
  * @param object $degree WP_Post object representing a degree
  * @return string HTML markup
  */
function get_degree_news_spotlight_modern_layout( $degree ) {
	$degree_news_shortcode = get_field( 'degree_news_shortcode', $degree );
	$degree_spotlight = get_field( 'degree_spotlight', $degree );

	if( empty( $degree_news_shortcode ) && empty( $degree_spotlight ) ) return '';

	ob_start();
	?>

	<div class="container py-lg-5">
		<div class="row justify-content-between align-items-end">
			<div class="col-auto">
				<h2 class="h1 mb-0">In The News</h2>
			</div>
			<div class=" col-auto">
				<p class="mb-0">
					<a class="h6 text-uppercase mb-0 text-default-aw" href="https://www.ucf.edu/news/">
						Check out more stories
						<span class="fa fa-external-link text-primary" aria-hidden="true"></span>
					</a>
				</p>
			</div>
		</div>

		<hr class="mt-2">

		<div class="row my-lg-3">

			<?php if( $degree_news_shortcode ) : ?>
				<div class="col-md-8">
					<?php echo do_shortcode( $degree_news_shortcode ); ?>
				</div>
			<?php endif; ?>

			<?php if( $degree_spotlight ) : ?>
				<div class="col-md-4">
					<?php echo do_shortcode( "[ucf-spotlight slug=" . $degree_spotlight->post_name . "]" ); ?>
				</div>
			<?php endif; ?>

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
 * Returns true|false if program_type is a graduate program.
 *
 * @since 3.3.8
 * @author RJ Bruneel
 * @param object $post  WP_Post object
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
 *
 * @author Jim Barnes
 * @since 3.0.0
 * @param object $degree | WP_Post object for the degree
 * @param string $btn_classes | CSS classes to apply to the button
 * @param string $icon_classes | CSS classes to apply to the inner icon in the button. Leave empty to omit icon
 * @param string $btn_text | Text to display within the button
 * @return string | The button markup.
 **/
function get_degree_apply_button( $degree, $btn_classes='btn btn-lg btn-block btn-primary', $icon_classes='fa fa-pencil pr-2', $btn_text='Apply Now' ) {
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
	<a class="<?php echo $btn_classes; ?>" href="<?php echo $apply_url; ?>">
		<?php if ( $icon_classes ): ?>
		<span class="fa fa-pencil pr-2" aria-hidden="true"></span>
		<?php endif; ?>

		<?php echo $btn_text; ?>
	</a>
<?php
	endif;

	return ob_get_clean();
}


/**
 * Gets the "Request Info" button markup for degrees.
 *
 * @author RJ Bruneel
 * @since 3.4.0
 * @param object $degree | WP_Post object representing a degree
 * @param string $btn_classes | CSS classes to apply to the button
 * @param string $icon_classes | CSS classes to apply to the inner icon in the button. Leave empty to omit icon
 * @param string $btn_text | Text to display within the button
 * @return string | The button markup.
 **/
function get_degree_request_info_button( $degree, $btn_classes='btn btn-primary', $icon_classes='', $btn_text='Request Information' ) {
	$modal = get_degree_request_info_modal( $degree );

	ob_start();

	// Don't render button if the corresponding Request Info
	// modal failed to render correctly:
	if ( $modal ) :
?>
	<button class="<?php echo $btn_classes; ?>" data-toggle="modal" data-target="#requestInfoModal">
		<?php if ( $icon_classes ): ?>
		<span class="<?php echo $icon_classes; ?>" aria-hidden="true"></span>
		<?php endif; ?>

		<?php echo $btn_text; ?>
	</button>
<?php
	endif;
	return trim( ob_get_clean() );
}


/**
 * Returns a complete URL for the graduate RFI form, with
 * optional params.
 *
 * @author Jo Dickson
 * @since 3.4.0
 * @param array $params Assoc. array of query params + values to append to the URL string
 * @return mixed URL string, or null if the URL base or form ID aren't set
 */
function get_degree_request_info_url_graduate( $params=array() ) {
	$base = get_theme_mod_or_default( 'degrees_graduate_rfi_url_base' );
	if ( ! $base ) return null;

	$form_id = get_theme_mod_or_default( 'degrees_graduate_rfi_form_id' );
	if ( ! $form_id ) return null;

	$params['id'] = $form_id;
	$separator = ( strpos( $base, '?' ) !== false ) ? '&' : '?';

	$url = $base . $separator . http_build_query( $params );
	return $url;
}


/**
 * Gets the "Request Info" modal markup for degrees.
 *
 * @author RJ Bruneel
 * @since 3.4.0
 * @param object $degree WP_Post object representing a degree
 * @return string | The modal markup.
 **/
function get_degree_request_info_modal( $degree ) {
	$markup = '';

	// If this isn't a graduate degree, return early.
	//
	// If/when we start supporting undergraduate RFIs, this
	// (and the rest of this function) will have to be adjusted:
	if ( ! is_graduate_degree( $degree ) ) return $markup;

	// Retrieve GUID data that map plan+subplan codes to programs
	// in the RFI form.  Back out early if something fails.
	$guid_data = file_get_contents( THEME_JS_DIR . '/guid.json' );
	if ( ! $guid_data ) return '';

	$degrees = json_decode( $guid_data, true );
	$plan_sub_plan = get_field( 'degree_plan_code', $degree ) . get_field( 'degree_subplan_code', $degree );
	$form_div_id  = 'form_bad6c39a-5c60-4895-9128-5785ce014085';
	$rfi_form_src = get_degree_request_info_url_graduate( array(
		'sys:field:pros_program1' => $degrees[$plan_sub_plan],
		'output' => 'embed',
		'div' => $form_div_id
	) );

	if ( $rfi_form_src ):
		ob_start();
?>
		<div class="modal fade" id="requestInfoModal" tabindex="-1" role="dialog" aria-labelledby="requestInfoModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header px-4 pt-4">
						<h2 class="h5 modal-title d-flex align-items-center" id="requestInfoModalLabel">
							<span class="fa fa-info-circle fa-2x mr-3" aria-hidden="true"></span>
							Request Information
						</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body mb-2 px-4 pb-4">
						<p class="mb-4">
							Enter your information below to receive more information about the <strong><?php echo wptexturize( $degree->post_title ); ?></strong> program offered at UCF.
						</p>
						<div id="<?php echo $form_div_id; ?>">Loading...</div>
						<script>
						/*<![CDATA[*/
						var script = document.createElement('script');
						script.async = 1;
						script.src = '<?php echo $rfi_form_src; ?>' + ((location.search.length > 1) ? '&' + location.search.substring(1) : '');
						var s = document.getElementsByTagName('script')[0];
						s.parentNode.insertBefore(script, s);
						/*]]>*/
						</script>
					</div>
				</div>
			</div>
		</div>
<?php
		$markup = trim( ob_get_clean() );
	endif;

	return $markup;
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

	ob_start();
?>
	<div class="card h-100 text-center">
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs" id="tuition-tabs" role="tablist">
				<?php if ( $resident ): ?>
				<li class="nav-item text-nowrap">
					<a class="nav-link active" id="resident-tuition-tab" data-toggle="tab" href="#resident-tuition" role="tab" aria-controls="resident-tuition" aria-selected="true">
						In State<span class="sr-only"> Tuition</span>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( $nonresident ): ?>
				<li class="nav-item text-nowrap">
					<a class="nav-link" id="nonresident-tuition-tab" data-toggle="tab" href="#nonresident-tuition" role="tab" aria-controls="nonresident-tuition" aria-selected="false">
						Out of State<span class="sr-only"> Tuition</span>
					</a>
				</li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="card-block d-flex flex-column justify-content-center px-sm-4 px-md-2 px-xl-3 pt-4 py-md-5 pt-lg-4 pb-lg-3 tab-content" id="tuition-panes">
			<?php if ( $resident ): ?>
			<div class="tab-pane fade show active" id="resident-tuition" role="tabpanel" aria-labelledby="resident-tuition-tab">
				<span class="d-block display-4">
					<?php echo str_replace( 'per credit hour', '', $resident ); ?>
				</span>
				<span class="d-block small text-uppercase font-weight-bold"> per credit hour</span>
			</div>
			<?php endif; ?>

			<?php if ( $nonresident ): ?>
			<div class="tab-pane fade <?php if ( ! $resident ) { ?>show active<?php } ?>" id="nonresident-tuition" role="tabpanel" aria-labelledby="nonresident-tuition-tab">
				<span class="d-block display-4">
					<?php echo str_replace( 'per credit hour', '', $nonresident ); ?>
				</span>
				<span class="d-block small text-uppercase font-weight-bold"> per credit hour</span>
			</div>
			<?php endif; ?>

			<?php if ( $disclaimer ) : ?>
			<p class="mt-4 mx-3 mb-0" style="line-height: 1.2;"><small><?php echo $disclaimer; ?></small></p>
			<?php endif; ?>
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

