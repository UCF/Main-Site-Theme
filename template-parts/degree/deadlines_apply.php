<?php
$post = isset( $post ) ? $post : get_queried_object();

if ( $post->post_type === 'degree' ) :
	// TODO replace content for programs without deadlines, minors, ugrad certs (existing Section selection)
	// TODO utilize imported deadline data
	$deadlines = get_field( 'application_deadlines', $post );
	$deadlines_count = is_array( $deadlines ) ? count( $deadlines ) : 0;

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
							<div class="row d-lg-flex justify-content-lg-between flex-lg-nowrap">
							<?php while ( have_rows( 'application_deadlines', $post ) ) : the_row(); ?>

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
								$post,
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
endif;
